<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendOtpNotification extends Notification
{
    use Queueable;

    private $otpCode;

    /**
     * Create a new notification instance.
     *
     * @param string $otpCode
     */
    public function __construct($otpCode)
    {
        $this->otpCode = $otpCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    /**
     * Get the Twilio representation of the notification.
     *
     * @param mixed $notifiable
     * @return TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content('Your OTP code: ' . $this->otpCode)
            ->from(Config::get('services.twilio.from'));
    }
}
