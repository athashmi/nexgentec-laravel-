<?php

namespace App\Console\Commands;

use App\Cron;
use App\Repositories\ReportsRepository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;

class ParseEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse emails from GMAIL';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $parsing_config = \Config::get('services')['email_parsing'];

        $inbox = imap_open($parsing_config['server'],$parsing_config['email'],$parsing_config['password'])
        or die('Cannot connect to Gmail: ' . imap_last_error());

        /* get all new emails. If set to 'ALL' instead
         * of 'NEW' retrieves all the emails, but can be
         * resource intensive, so the following variable,
         * $max_emails, puts the limit on the number of emails downloaded.
         *
         */
/*        $cron = Cron::orderBy('id','desc')->first(['date']);
        $current_date = date("Y-m-d");

        $date = $current_date;//$current_date;
        if(!is_null($cron)) {
            $date = $cron->date;
        }*/

        $current_time = time();
        $time_stamp = $current_time - 24*60*60;
        $date = date("Y-m-d", $time_stamp);


        $emails = imap_search($inbox,'SINCE "'.$date.'"');
        /* useful only if the above search is set to 'ALL' */

        /* if any emails found, iterate through each email */
        if($emails) {

            $count = 1;

            /* put the newest emails on top */
            //rsort($emails);

            /* for every email... */

            foreach($emails as $email_number) {

                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox,$email_number,0);
                /* get header of email */
                $header = imap_header($inbox,$email_number,0);
                /* get mail message */
                $message = imap_fetchbody($inbox,$email_number,2);

                /* get mail structure */
                $structure = imap_fetchstructure($inbox, $email_number);

                $attachments = array();
                // echo "<pre>",print_r($header,true);//exit;
                // echo print_r($structure);exit;
                /* if any attachments found... */
                if(isset($structure->parts) && count($structure->parts)) {
                    //echo "sadasd";exit;
                    for($i = 1; $i < count($structure->parts); $i++) {
                        $attachments[$i] = array(
                            'is_attachment' => false,
                            'filename' => '',
                            'name' => '',
                            'attachment' => '',
                            'sender_email' => $header->sender[0]->mailbox.'@'.$header->sender[0]->host
                        );

                        if($structure->parts[$i]->ifdparameters) {
                            foreach($structure->parts[$i]->dparameters as $object) {
                                if(strtolower($object->attribute) == 'filename') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
                                    $attachments[$i]['filename'] = $object->value;
                                }
                            }
                        }

                        if($structure->parts[$i]->ifparameters) {
                            foreach($structure->parts[$i]->parameters as $object) {
                                if(strtolower($object->attribute) == 'name') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }

                        if($attachments[$i]['is_attachment']) {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                            /* 4 = QUOTED-PRINTABLE encoding */
                            if($structure->parts[$i]->encoding == 3) {
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            }
                            /* 3 = BASE64 encoding */
                            elseif($structure->parts[$i]->encoding == 4) {
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
                    }
                }
                /* iterate through each attachment and save it */
                foreach($attachments as $attachment) {

                    if($attachment['is_attachment'] == 1) {
                        $filename = $attachment['name'];
                        if(empty($filename)) $filename = $attachment['filename'];

                        if(empty($filename)) $filename = time() . ".dat";

                        /* prefix the email number to the filename in case two emails
                         * have the attachment with the same file name.
                         */

                        $User = User::where('email', $attachment['sender_email'])->first(['id']);

                        $user_dir = storage_path().'/'.$User->id;

                        if(!is_dir($user_dir)) {
                            mkdir($user_dir);
                        }

                        $fp = fopen($user_dir . "/" . $filename, "w+");
                        fwrite($fp, $attachment['attachment']);
                        fclose($fp);

                        $attachment['file_path'] = $user_dir.'/'.$filename;
                        $attachment['file_name'] = $filename;
                        $attachment['user_id']   = $User->id;

                        $handle = fopen($user_dir . "/" . $filename, 'r');
                        $row = fgetcsv($handle, 1000, ',');
                        fclose($handle);

                        /*if($row[0] == "Driver Name") {
                            $attachment['report_type'] = 'Uber';
                            $response  = ReportsRepository::addUberCSV($attachment);
                        } elseif ($row[0] == "START_DATE*") {
                            $attachment['report_type'] = 'MileIQ';
                            $response  = ReportsRepository::addMileIQCSV($attachment);
                        }*/
                        //return $response;

                    }

                }

                //if($count++ >= $max_emails) break;
            }
        }
        /* close the connection */
        imap_close($inbox);
    }
}
