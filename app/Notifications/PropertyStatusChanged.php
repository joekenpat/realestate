<?php

namespace App\Notifications;

use App\Property;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyStatusChanged extends Notification
{
  use Queueable;

  protected $user;
  protected $property;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, Property $property)
  {
    $this->user = $user;
    $this->property = $property;
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
    $greeting = sprintf("Hello! %s", $this->user->first_name);
    $title = sprintf("Change in status of property: %s", $this->property->title);
    $message1 = sprintf("Your property %s is now: %s", $this->property->title, $this->property->status);
    return (new MailMessage)
      ->line('The introduction to the notification.')
      ->action('view your properties', route('user_list_property'))
      ->line('Thank you for taking your time to read this email')
      ->line(sprintf("You are receiving this email because your are a registered %s at mynextland.com", ucwords($this->user->role)));
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
