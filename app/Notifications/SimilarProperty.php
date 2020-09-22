<?php

namespace App\Notifications;

use App\Property;
use App\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class SimilarProperty extends Notification implements ShouldQueue
{
  use Queueable;
  protected $subscriber;
  protected $property;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Subscriber $subscriber, Property $property)
  {
    $this->subscriber = $subscriber;
    $this->property = $subscriber;
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
    $greeting = sprintf("Hello! %s", $this->subscriber->name);
    $title = sprintf("A New ₦%s Property  for %s", number_format($this->property->price), $this->property->list_as);
    $message1 = "A new property matching the criteria you subscribed to has been posted";
    $message2 = sprintf("%s goes for %s as it is up for ", $this->property->title, $this->property->price->title, $this->property->list_as);
    $message3 = "you can get more information about the property by clicking the link below.";
    $message4 = sprintf("if you would like to unsubscribe from receiving further emails you can use the URL: <a href='%s'>Unsubscribe Now</a>", URL::signedRoute('property_unsubscribe', ['subscriber_id', $this->subscriber->id]));
    return (new MailMessage)
      ->subject($title)
      ->greeting($greeting)
      ->line($message1)
      ->line($message2)
      ->line($message3)
      ->action('View Property', route('view_property', ['property_slug' => $this->property->slug]))
      ->line('Thank you for taking your time to read this email')
      ->line($message4);
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
