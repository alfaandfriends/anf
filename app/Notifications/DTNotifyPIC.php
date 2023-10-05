<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class DTNotifyPIC extends Notification
{
    use Queueable;

    public $info;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->level("success")
            ->subject("Mathematics Diagnostic Test Report")
            ->with(new HtmlString("<p style='color: black'>Dear <strong>" . $this->info['user_name'] . "</strong>,</p>"))
            ->with("")
            ->with(new HtmlString("<p style='color: black'><strong>" . $this->info['student_name'] . " (Age " . $this->info['student_age'] . ")</strong> has successfully completed the diagnostic test for <strong>" . $this->info['dt_title'] . "</strong>. The test was administered on <strong>" . $this->info['test_date'] . "</strong> and the results have been recorded.</p>"))
            ->with("")
            ->with(new HtmlString("<p style='color: black'>It has been reviewed and certain areas have been identified where <strong>" . $this->info['student_name'] . "</strong> may need additional support and guidance.</p>"))
            ->action('View Report', route('diagnostic_test.report', $this->info['result_id']))
            ->salutation(new HtmlString("<p style='color: dimgrey'>Regards,<br>ALFA and Friends Centre</p>"));;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
