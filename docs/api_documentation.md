# Auction API Documentation

## Table of Contents
1. [Authentication Routes](#authentication-routes)
2. [Protected Routes](#protected-routes)
3. [Unprotected Routes](#unprotected-routes)
4. [Response Formats](#response-formats)
5. [Error Handling](#error-handling)

## Base URL
```
https://your-domain.com/api
```

## Authentication
This API uses Laravel Passport OAuth2 for authentication. Protected routes require a Bearer token in the Authorization header.

```
Authorization: Bearer {your-access-token}
```

---

## Authentication Routes

### 1. Social Login
**GET** `/social/authentication`

Handles social media authentication.

**Response:**
```json
{
  "access_token": "string",
  "token_type": "Bearer",
  "expires_at": "datetime"
}
```

### 2. User Registration
**POST** `/auth/register`

Register a new user account.

**Request Body:**
```json
{
  "name": "string (required)",
  "email": "string (required, email format)",
  "password": "string (required, min:8)",
  "password_confirmation": "string (required)"
}
```

**Response:**
```json
{
  "status": true,
  "message": "User registered successfully",
  "user": {
    "id": "integer",
    "name": "string",
    "email": "string"
  }
}
```

### 3. User Login
**POST** `/auth/login`

Authenticate user and generate OAuth token.

**Request Body:**
```json
{
  "email": "string (required)",
  "password": "string (required)"
}
```

**Response:**
```json
{
  "access_token": "string",
  "token_type": "Bearer",
  "expires_at": "datetime",
  "user": {
    "userid": "integer",
    "username": "string",
    "email": "string"
  }
}
```

### 4. Email Verification
**GET** `/auth/verify`

Verify user email address.

**Query Parameters:**
- `token`: string (required) - Verification token

### 5. Reset Password
**GET** `/auth/reset/password`

Initiate password reset process.

**Query Parameters:**
- `email`: string (required) - User email

### 6. Change Password
**POST** `/auth/change/password`

Change user password using reset token.

**Request Body:**
```json
{
  "token": "string (required)",
  "password": "string (required, min:8)",
  "password_confirmation": "string (required)"
}
```

---

## Protected Routes
*Requires Authentication*

### 1. Get User Data
**GET** `/user`

Get authenticated user information.

**Response:**
```json
{
  "userid": "integer",
  "username": "string",
  "email": "string",
  "first_name": "string",
  "last_name": "string",
  "phone": "string",
  "address": "string",
  "city": "string",
  "state": "string",
  "country": "string",
  "zip": "string"
}
```

### 2. Update User Profile
**POST** `/user/update`

Update user profile information.

**Request Body:**
```json
{
  "firstName": "string (required)",
  "lastName": "string (required)",
  "mobile": "string (required)",
  "street": "string (required)",
  "city": "string (required)",
  "state": "string (required)",
  "zipcode": "string (required)",
  "country": "string (required)"
}
```

**Response:**
```json
{
  "status": true,
  "msg": "Profile updated successfully"
}
```

### 3. Get Watchlist
**GET** `/watchlist`

Get user's watchlist products.

**Response:**
```json
[
  {
    "id": "integer",
    "title": "string",
    "thumbnail": "string (full URL)",
    "current_bid": "decimal",
    "end_time": "datetime"
  }
]
```

### 4. Add to Watchlist
**POST** `/add/watchlist`

Add product to user's watchlist.

**Request Body:**
```json
{
  "pid": "integer (required)"
}
```

**Response:**
```json
{
  "status": true,
  "message": "Product added to your watchlist"
}
```

### 5. Remove from Watchlist
**POST** `/watchlist/remove`

Remove product from user's watchlist.

**Request Body:**
```json
{
  "pid": "integer (required)"
}
```

**Response:**
```json
{
  "status": true,
  "message": "Product removed from your watchlist"
}
```

### 6. Dashboard Data
**GET** `/datas`

Get user dashboard statistics.

**Response:**
```json
{
  "status": true,
  "watchcount": "integer",
  "winningcount": "integer",
  "loosingcount": "integer"
}
```

### 7. Place Proxy Bid
**POST** `/bid`

Place a proxy bid on a product.

**Request Body:**
```json
{
  "pid": "integer (required)",
  "amount": "decimal (required)"
}
```

**Response:**
```json
{
  "msg": "Bid placed Successfully"
}
```

**Possible Response Messages:**
- "Bid placed Successfully"
- "User placed maximum bid"
- "Proxy bid Inserted"
- "Tie Happens you can set higher amount to win this"
- "Please!, Enter higher amount than Current bid value"
- "Auction Expired..."

### 8. Get My Bids
**GET** `/mybids`

Get products the user has bid on.

**Response:**
```json
[
  {
    "id": "integer",
    "title": "string",
    "thumbnail": "string (full URL)",
    "current_bid": "decimal",
    "end_time": "datetime"
  }
]
```

### 9. Request Pickup
**POST** `/request-pickup`

Request pickup for a won item.

**Request Body:**
```json
{
  "pid": "integer (required)",
  "msg": "string (optional)",
  "schedule": "string (required)"
}
```

**Response:**
```json
{
  "status": true,
  "msg": "Pickup requested"
}
```

### 10. Request Support
**POST** `/request-support`

Submit a support request.

**Request Body:**
```json
{
  "pid": "integer (required)",
  "question": "string (required)"
}
```

**Response:**
```json
{
  "status": true,
  "msg": "Support requested, we will get back to you soon"
}
```

### 11. Get Notifications
**GET** `/notification`

Get user notifications.

**Response:**
```json
[
  {
    "id": "integer",
    "username": "string",
    "message": "string",
    "created_at": "datetime"
  }
]
```

### 12. Get Invoice
**GET** `/get-invoice`

Get user invoices.

**Response:**
```json
[
  {
    "id": "integer",
    "invoice_number": "string",
    "uid": "integer",
    "amount": "decimal",
    "status": "string",
    "created_at": "datetime"
  }
]
```

---

## Unprotected Routes

### 1. Get Bid History
**GET** `/bidhistory`

Get bid history for a specific product.

**Query Parameters:**
- `pid`: integer (required) - Product ID

**Response:**
```json
[
  {
    "id": "integer",
    "user_id": "integer",
    "product_id": "integer",
    "bidder": "string",
    "amount": "decimal",
    "status": "string",
    "created_at": "datetime"
  }
]
```

### 2. Get App Data
**GET** `/app-data`

Get application settings and content.

**Response:**
```json
{
  "policy": "string",
  "terms": "string",
  "shipping": "string",
  "about": "string",
  "consignment": "string",
  "suspension": "string"
}
```

### 3. Store Contact
**POST** `/contact`

Submit a contact form.

**Request Body:**
```json
{
  "firstname": "string (required)",
  "lastname": "string (required)",
  "mobile": "string (required)",
  "email": "string (required, email format)",
  "subject": "string (required)",
  "message": "string (required)"
}
```

**Response:**
```json
{
  "status": true,
  "message": "Contact Received Successfully"
}
```

### 4. Get All Categories
**GET** `/categories`

Get all product categories with product counts.

**Response:**
```json
[
  {
    "cat_id": "integer",
    "category_name": "string",
    "category_thumbnail": "string (full URL)"
  }
]
```

### 5. Get All Products
**GET** `/products/all`

Get all products from active auction (paginated, 6 per page).

**Response:**
```json
{
  "data": [
    {
      "id": "integer",
      "title": "string",
      "thumbnail": "string (full URL)",
      "images": ["string (full URLs)"],
      "current_bid": "decimal",
      "end_time": "datetime",
      "condition_rating": "integer"
    }
  ],
  "current_page": "integer",
  "last_page": "integer",
  "total": "integer"
}
```

### 6. Get Latest Products
**GET** `/products/latest`

Get latest products from active auction (paginated, 6 per page).

**Response:** Same format as Get All Products

### 7. Get Filtered Products
**GET** `/products/filter`

Get products filtered by condition rating.

**Query Parameters:**
- `term`: string (required) - "lth" (low to high) or "htl" (high to low)

**Response:** Same format as Get All Products (12 per page)

### 8. Get Product by ID
**GET** `/products`

Get single product details.

**Query Parameters:**
- `product_id`: integer (required) - Product ID

**Response:**
```json
{
  "id": "integer",
  "title": "string",
  "description": "string",
  "thumbnail": "string (full URL)",
  "images": ["string (full URLs)"],
  "current_bid": "decimal",
  "starting_bid": "decimal",
  "end_time": "datetime",
  "condition_rating": "integer",
  "condition_desc": "string",
  "category_id": "integer"
}
```

### 9. Get Products by Category
**GET** `/category/product`

Get products by category name.

**Query Parameters:**
- `category`: string (required) - Category name

**Response:** Same format as Get All Products

### 10. Search Products
**GET** `/search`

Search products by title or condition description.

**Query Parameters:**
- `term`: string (required) - Search term

**Response:** Same format as Get All Products

### 11. Approve Invoice Acknowledgement
**GET** `/invoice/{number}`

Approve invoice acknowledgement by invoice number.

**URL Parameters:**
- `number`: string (required) - Invoice number

---

## Response Formats

### Success Response
```json
{
  "status": true,
  "message": "Operation successful",
  "data": {}
}
```

### Error Response
```json
{
  "status": false,
  "message": "Error message",
  "error": {}
}
```

### Validation Error Response
```json
{
  "error": {
    "field_name": [
      "Validation error message"
    ]
  }
}
```

---

## Error Handling

### HTTP Status Codes
- `200` - Success
- `400` - Bad Request (Validation errors)
- `401` - Unauthorized
- `404` - Not Found
- `422` - Unprocessable Entity
- `500` - Internal Server Error

### Common Error Messages
- "unauthenticated" - User not logged in
- "Auction Expired" - Auction is no longer active
- "No Products Found" - No products match the criteria
- "Invalid Filter Request" - Filter parameter is invalid

---

## Notes

1. All timestamps are in MySQL datetime format: `YYYY-MM-DD HH:MM:SS`
2. Image URLs are automatically prepended with the full application URL
3. Pagination is available on most product listing endpoints
4. Authentication is required for all user-specific operations
5. Product images are stored as JSON arrays and decoded for API responses
6. Bid amounts are handled as decimal values
7. Time-sensitive operations (bidding) include automatic time extension logic