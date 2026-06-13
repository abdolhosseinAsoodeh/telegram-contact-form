# Telegram Contact Form

A simple, modern, single-page "Contact Us" form with a dark theme. Submitted messages are sent directly to a Telegram bot via a lightweight PHP backend.

## Features

- Clean, modern dark UI
- Fully responsive layout
- Contact form (name, phone, email, message)
- Messages delivered instantly to a Telegram chat/bot
- No database required

## Tech Stack

- HTML5 / CSS3
- Vanilla JavaScript (Fetch API)
- PHP (server-side request to Telegram Bot API)

## How It Works

1. User fills out the contact form and clicks send.
2. JavaScript sends the form data to `send.php`.
3. `send.php` formats the message and forwards it to the Telegram Bot API.
4. The message appears instantly in the configured Telegram chat.

## Project Structure

```
├── index.html      Main contact page (markup)
├── style.css       Styling (dark theme)
├── send.php        Backend script that relays messages to Telegram
└── htaccess        Apache configuration (rename to .htaccess to use)
```

## Setup

1. Create a Telegram bot via [@BotFather](https://t.me/BotFather) and get the bot token.
2. Get your chat ID via [@userinfobot](https://t.me/userinfobot).
3. Add your bot token and chat ID inside `send.php`.
4. Upload all files to a PHP-enabled web server.
5. Rename `htaccess` to `.htaccess`.

## Preview

A dark-themed, two-column contact page with company info on one side and a message form on the other.

## License

Free to use for personal and commercial projects.
