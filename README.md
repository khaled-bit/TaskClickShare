### Summary of Work Done:

#### 1. **Models and Relations**
   - **`Product` Model**: Represents products, containing fields like `product_name`, `description`, `product_code`, and relations to `ProductValue`.
   - **`Attribute` Model**: Represents attributes that can be dynamically added to products, containing fields like `name` and `type`.
   - **`ProductValue` Model**: Represents the values associated with each product attribute, linked by `product_id` and `attribute_id`.
   - **`Country` Model**: Added to handle country-specific details associated with products.
   - **EAV (Entity-Attribute-Value) Model**: Implemented to allow dynamic attributes for products, facilitating flexibility in adding new product characteristics without modifying the database schema.

#### 2. **Services**
   - **`ProductsHandler and OrdesHandler`**: Manages the ingestion of product and order data from Google Sheets, including validation and dynamic attribute handling.
   - **`GoogleSheetsService`**: Handles API interactions with Google Sheets, fetching data dynamically based on the provided sheet name and range.

#### 3. **Handling Dynamic Attributes**
   - Dynamically determine data types for attributes based on the actual values from the sheet, enhancing the **EAV** model implementation.
   - Ensure attributes and their values are only created if the data is non-empty, maintaining data integrity and avoiding unnecessary database entries.

#### 4. **Error Handling and Logging**
   - Added comprehensive error handling and logging to capture and debug issues during data ingestion and processing, especially for validation failures and missing data.

#### 5. **Database Migrations**
   - Created migrations to set up tables for `products`, `attributes`, `product_values`, and optionally `countries`, including foreign keys and necessary constraints for relationships.

#### 6. **Integration with Google Sheets**
   - Set up a service to fetch data from Google Sheets, allowing dynamic column handling to adapt to changes in the sheet structure.
   - Implemented logic to handle varying numbers of columns in data sheets, ensuring robust data fetching even when new columns are added.

### Steps to Run the Code
#### links for google sheets:
https://docs.google.com/spreadsheets/d/1CybQUTIex-Tejpo3qt-a8TTeq0VzfOg4FekWeu2xdl8/edit?pli=1#gid=0

#### Step 1: Install Composer Dependencies

```bash
composer install
```

#### Step 2: Install NPM Packages

```bash
npm install
npm run dev  # or npm run prod for production build
```

#### Step 3: Configure Environment
Make sure your `.env` file is set up correctly, particularly for database connections and any API keys needed for Google Sheets integration.

#### Step 4: Run Migrations
```bashphp artisan migrate
```

#### Step 5: Start the Laravel Development Server
```bash
php artisan serve
```
This will typically host your application on `http://127.0.0.1:8000`.

#### Step 6: Run Scheduled Jobs or Commands
```bash
php artisan fetch:orders  
```
