<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Book;
class BookAdded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $book;

    public function __construct(Book $book)
    {
        $this->book=$book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
     //   \Log::debug('title'.$this->book->title);
        return (new MailMessage)
                    ->subject('A New Book is Added')
                    ->line('Book Details are as follows: ')
                    ->line('Title: '.$this->book->title)
                    ->line('Author Name: '. $this->book->author_name)
                    ->line('Description: '. $this->book->description)
                    ->line('Price: '.$this->book->price)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
