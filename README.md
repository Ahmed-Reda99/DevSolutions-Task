# Real-Time Chat System in Laravel

This project implements a **real-time chat system** using Laravel, JWT
authentication, event broadcasting, WebSockets (Pusher), and Laravel
Echo.

It fulfills all the requirements of the technical assessment:

-   RESTful chat API
-   JWT-secured endpoints
-   Real-time message broadcasting
-   Private channel authorization
-   Queue-based broadcasting
-   Unit/Feature tests
-   Postman API documentation

------------------------------------------------------------------------

## 🚀 Project Setup

### 1) Clone the project

``` bash
git clone https://github.com/Ahmed-Reda99/DevSolutions-Task.git
cd <project-folder>
```

### 2) Install dependencies

``` bash
composer install
npm install
```

### 3) Environment file

``` bash
cp .env.example .env
php artisan key:generate
```

Configure your database inside `.env`.

------------------------------------------------------------------------

## 🔐 JWT Authentication

This project uses JWT for securing API endpoints.

> There is no registration route. Test users are seeded into the
> database.

After seeding, use the existing users to generate JWT tokens via the
login endpoint and use:

    Authorization: Bearer YOUR_TOKEN

for all `/api/chat/*` requests.

------------------------------------------------------------------------

## 📡 Pusher (WebSockets) Setup

Create a Pusher Channels app at: https://pusher.com

Add these values to `.env`:

    BROADCAST_DRIVER=pusher
    QUEUE_CONNECTION=database

    PUSHER_APP_ID=your_id
    PUSHER_APP_KEY=your_key
    PUSHER_APP_SECRET=your_secret
    PUSHER_APP_CLUSTER=your_cluster

------------------------------------------------------------------------

## 🗄️ Database, Seeds & Queues

Run migrations and seed test users:

``` bash
php artisan migrate
php artisan db:seed
```

------------------------------------------------------------------------

## ▶️ Running the Project

You must run **all of the following**:

``` bash
php artisan serve
php artisan queue:work
npm run dev
```

> ⚠️ The queue worker **must be running** for real-time broadcasting to
> work.

------------------------------------------------------------------------

## 📮 API Endpoints

### ✅ Send Message

**POST** `/api/chat/send`

``` json
{
  "receiver_id": 2,
  "message": "Hello"
}
```

------------------------------------------------------------------------

### ✅ Retrieve Messages (Paginated)

**GET** `/api/chat/messages/{user_id}`

------------------------------------------------------------------------

### ✅ Mark Message as Read

**PATCH** `/api/chat/read/{message_id}`

------------------------------------------------------------------------

## ⚡ Real-Time Test (Echo Demo)

A demo page is included to prove real-time messaging.

### Steps:

1.  Login via Postman and copy your JWT token
2.  Open:

```{=html}
    http://localhost:8000/echo-test
```

3.  Paste your token into echo-test.blade.php
4.  Keep the page open
5.  From Postman, send a message to that user ID
6.  You will see the message instantly in the browser

This confirms WebSocket broadcasting is working.

------------------------------------------------------------------------

## 🧪 Running Tests

``` bash
php artisan test
```

Tests cover:

-   Message storage via API
-   JWT authentication
-   Event dispatching
-   Message retrieval with correct pagination structure

------------------------------------------------------------------------

## 📑 Postman Collection

A Postman collection is included in the repository.

Import it into Postman and start testing immediately.

------------------------------------------------------------------------

## 🧠 Important Technical Notes

-   Broadcasting uses **private channels** secured by JWT
-   Events implement `ShouldBroadcast`
-   Broadcasting is processed through queues
-   Database indexes are applied for performance
-   Business logic is separated into a service class (SOLID principles)

------------------------------------------------------------------------

## ✅ Requirements Checklist

  Requirement              Implemented
  ------------------------ -------------
  DB Schema & Indexes      ✅
  RESTful API              ✅
  JWT Security             ✅
  Real-time Broadcasting   ✅
  Private Channels         ✅
  Queue-based Events       ✅
  Unit/Feature Tests       ✅
  API Documentation        ✅

------------------------------------------------------------------------

You can now run the project and test real-time chat in less than 5
minutes.
