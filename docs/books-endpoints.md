# Books API endpoints
## Common rules

- Base path: `/api/books`
- Request format: `application/json`
- Response format: `application/json`
- All book and borrower serial numbers must be within the `100000-999999` range
- For API error responses, send the `Accept: application/json` header

## GET `/api/books`

Returns the list of books.

### `200 OK` response

```json
[
  {
    "serial_id": 123456,
    "title": "Book 1",
    "author": "Author 1",
    "is_available": true
  }
]
```

### Response fields

- `serial_id` - book serial number
- `title` - title
- `author` - author
- `is_available` - availability flag

## POST `/api/books`

Creates a new book.

### Body

```json
{
  "serial_id": 123456,
  "title": "Book 1",
  "author": "Author 1"
}
```

### Validation

- `serial_id` - required, integer, range `100000-999999`
- `title` - required, max 255 characters
- `author` - required, max 255 characters

### `200 OK` response

Empty JSON response:

```json
{}
```

### Errors

- a conflict for an existing `serial_id` returns `409 Conflict` with code `B0002`
- other unhandled exceptions return `500 Internal Server Error` with code `B0001`

## PUT `/api/books`

Updates the book hire status.

### Body

```json
{
  "book_serial_id": 123456,
  "borrower_serial_id": 654321,
  "hire_status": "borrowed"
}
```

### Validation

- `book_serial_id` - required, integer, range `100000-999999`
- `borrower_serial_id` - required, integer, range `100000-999999`
- `hire_status` - required

### `200 OK` response

```json
{}
```

## DELETE `/api/books`

Deletes a book.

### Body

```json
{
  "serial_id": 123456
}
```

### Validation

- `serial_id` - required, integer, range `100000-999999`

### `200 OK` response

```json
{}
```

## Implementation notes

- The endpoints share the same `/api/books` path and are distinguished only by HTTP method.
- Error handling for this area is wired through `ExceptionSubscriber`, which maps exceptions to JSON.