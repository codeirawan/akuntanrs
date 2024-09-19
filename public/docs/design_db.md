Here's a full version of the database structure with English table and column names:

### **1. Cashier**
- **Table: `cashier_transactions`**
  - **Columns:**
    - `transaction_id` (Primary Key)
    - `transaction_type` (enum: 'cash', 'non_cash', 'receivable', 'petty_cash')
    - `amount` (decimal)
    - `transaction_date` (datetime)
    - `description` (text)
    - `patient_id` (Foreign Key to `patients` table, nullable for non-patient transactions)
    - `user_id` (Foreign Key to `users` table)

- **Table: `cashier_receivables`**
  - **Columns:**
    - `receivable_id` (Primary Key)
    - `patient_id` (Foreign Key to `patients` table)
    - `receivable_amount` (decimal)
    - `status` (enum: 'unpaid', 'paid')
    - `transaction_date` (datetime)
    - `payment_date` (datetime, nullable)

### **2. Pharmacy & Laboratory**
- **Table: `supplier_purchases`**
  - **Columns:**
    - `purchase_id` (Primary Key)
    - `supplier_id` (Foreign Key to `suppliers` table)
    - `purchase_date` (datetime)
    - `total_amount` (decimal)
    - `status` (enum: 'unpaid', 'paid')

- **Table: `bhp_withdrawals`**
  - **Columns:**
    - `withdrawal_id` (Primary Key)
    - `item_id` (Foreign Key to `pharmacy_items` table)
    - `unit_id` (Foreign Key to `units` table)
    - `withdrawal_quantity` (int)
    - `withdrawal_date` (datetime)

- **Table: `hpp_calculations`**
  - **Columns:**
    - `hpp_id` (Primary Key)
    - `item_id` (Foreign Key to `pharmacy_items` table)
    - `cost_price` (decimal)
    - `calculation_date` (datetime)

### **3. Logistic Warehouse**
- **Table: `logistic_supplier_purchases`**
  - **Columns:**
    - `purchase_id` (Primary Key)
    - `supplier_id` (Foreign Key to `suppliers` table)
    - `purchase_date` (datetime)
    - `total_amount` (decimal)
    - `status` (enum: 'unpaid', 'paid')

- **Table: `logistic_usage`**
  - **Columns:**
    - `usage_id` (Primary Key)
    - `item_id` (Foreign Key to `logistic_items` table)
    - `unit_id` (Foreign Key to `units` table)
    - `usage_quantity` (int)
    - `usage_date` (datetime)

### **4. General Warehouse**
- **Table: `general_supplier_purchases`**
  - **Columns:**
    - `purchase_id` (Primary Key)
    - `supplier_id` (Foreign Key to `suppliers` table)
    - `purchase_date` (datetime)
    - `total_amount` (decimal)
    - `status` (enum: 'unpaid', 'paid')

### **5. Cash and Bank**
- **Table: `cash_bank_transactions`**
  - **Columns:**
    - `transaction_id` (Primary Key)
    - `source_transaction_id` (Foreign Key to `cashier_transactions`, `cash_bank_transactions`)
    - `transaction_type` (enum: 'receipt', 'payment')
    - `amount` (decimal)
    - `transaction_date` (datetime)
    - `description` (text)

### **6. Medical Services**
- **Table: `medical_service_transactions`**
  - **Columns:**
    - `transaction_id` (Primary Key)
    - `doctor_id` (Foreign Key to `doctors` table)
    - `patient_id` (Foreign Key to `patients` table)
    - `service_type` (text)
    - `amount` (decimal)
    - `transaction_date` (datetime)

### **7. Accounts Payable******
- **Table: `accounts_payable`**
  - **Columns:**
    - `payable_id` (Primary Key)
    - `supplier_id` (Foreign Key to `suppliers` table)
    - `payable_amount` (decimal)
    - `payable_date` (datetime)
    - `due_date` (datetime)
    - `status` (enum: 'unpaid', 'paid')
    - `purchase_id` (Foreign Key to `supplier_purchases`, `logistic_supplier_purchases`, `general_supplier_purchases`)

### **8. Accounts Receivable**
- **Table: `accounts_receivable`**
  - **Columns:**
    - `receivable_id` (Primary Key)
    - `patient_id` (Foreign Key to `patients` table)
    - `receivable_amount` (decimal)
    - `receivable_date` (datetime)
    - `due_date` (datetime)
    - `status` (enum: 'unpaid', 'paid')

### **9. General Journal**
- **Table: `general_journal`**
  - **Columns:**
    - `journal_id` (Primary Key)
    - `journal_date` (datetime)
    - `description` (text)
    - `total_debit` (decimal)
    - `total_credit` (decimal)

- **Table: `journal_entries`**
  - **Columns:**
    - `entry_id` (Primary Key)
    - `journal_id` (Foreign Key to `general_journal`)
    - `debit_account` (Foreign Key to `accounts`)
    - `credit_account` (Foreign Key to `accounts`)
    - `amount` (decimal)

### **10. Financial Reports**
- **Table: `general_ledger`**
  - **Columns:**
    - `ledger_id` (Primary Key)
    - `start_date` (datetime)
    - `end_date` (datetime)
    - `description` (text)

- **Table: `income_statement`**
  - **Columns:**
    - `statement_id` (Primary Key)
    - `start_date` (datetime)
    - `end_date` (datetime)
    - `description` (text)

- **Table: `balance_sheet`**
  - **Columns:**
    - `sheet_id` (Primary Key)
    - `start_date` (datetime)
    - `end_date` (datetime)
    - `description` (text)

### **11. Fixed Assets**
- **Table: `fixed_assets`**
  - **Columns:**
    - `asset_id` (Primary Key)
    - `asset_name` (text)
    - `acquisition_date` (datetime)
    - `asset_value` (decimal)
    - `depreciation_value` (decimal)
    - `asset_life` (int)
    - `asset_location` (text)

---

### **Table Relationships:**

- **`cashier_transactions`** is related to **`cashier_receivables`** for handling receivable transactions.
- **`supplier_purchases`**, **`logistic_supplier_purchases`**, and **`general_supplier_purchases`** are linked to **`accounts_payable`** for tracking supplier payables.
- **`cash_bank_transactions`** can record both internal bank transactions and **cashier_transactions**.
- **`general_journal`** will record every transaction from modules like **Pharmacy**, **Logistics**, **Cashier**, and **Medical Services** for financial entries.

---
