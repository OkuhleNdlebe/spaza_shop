# Domain Model for Counterfeit System

## Domain Entities

### 1. Product
| Attribute          | Description                     |
|--------------------|---------------------------------|
| `id`              | Unique identifier for the product |
| `name`            | Name of the product             |
| `category`        | Category of the product         |
| `authenticityScore` | Numerical score indicating authenticity |
| `manufacturer`    | Manufacturer of the product     |
| `status`          | Status of the product (e.g., "Authentic", "Counterfeit")|

**Methods**: 
- `verifyAuthenticity()`: Validates the product's authenticity.
- `updateStatus()`: Updates the product's status based on verification.

**Relationships**:
- A **Product** can trigger an **Alert** if flagged as counterfeit.

---

### 2. User
| Attribute          | Description                     |
|--------------------|---------------------------------|
| `id`              | Unique identifier for the user  |
| `name`            | Name of the user               |
| `email`           | Email address of the user      |
| `role`            | Role of the user (e.g., "Admin", "Inspector")|
| `reportLimit`     | Maximum number of reports the user can submit per day |

**Methods**: 
- `submitReport()`: Allows the user to submit a counterfeit report.
- `viewAlerts()`: Enables the user to view active alerts.

**Relationships**:
- A **User** submits a **Report** for a **Product**.

---

### 3. Report
| Attribute          | Description                     |
|--------------------|---------------------------------|
| `id`              | Unique identifier for the report|
| `productId`       | ID of the reported product      |
| `userId`          | ID of the user who submitted the report |
| `description`     | Description of the issue        |
| `timestamp`       | Submission date and time        |
| `status`          | Status of the report (e.g., "Pending", "Reviewed")|

**Methods**: 
- `create()`: Creates a new report.
- `updateStatus()`: Updates the status of the report.

**Relationships**:
- A **Report** is associated with a **Product** and a **User**.

---

### 4. Alert
| Attribute          | Description                     |
|--------------------|---------------------------------|
| `id`              | Unique identifier for the alert |
| `productId`       | ID of the product triggering the alert |
| `severity`        | Severity level of the alert     |
| `timestamp`       | Date and time of the alert      |

**Methods**: 
- `generate()`: Generates an alert for a counterfeit product.
- `resolve()`: Marks the alert as resolved.

**Relationships**:
- An **Alert** is generated for a **Product** and can be viewed by a **User**.

---

### 5. Compliance Dashboard
| Attribute          | Description                     |
|--------------------|---------------------------------|
| `id`              | Unique identifier for the dashboard |
| `userId`          | ID of the associated user       |
| `totalReports`    | Total number of reports submitted |
| `resolvedReports` | Number of reports resolved      |
| `activeAlerts`    | Number of active alerts         |

**Methods**: 
- `generateSummary()`: Provides a summary of reports and alerts.
- `viewDetails()`: Allows users to view detailed statistics.

**Relationships**:
- A **Compliance Dashboard** is associated with a **User** and aggregates data from **Reports** and **Alerts**.

---

## Business Rules
1. A **User** can submit a maximum of 3 reports per day.
2. A **Product** is flagged as counterfeit if its `authenticityScore < 50`.
3. A **Report** can only be created for an existing **Product**.
4. An **Alert** is generated automatically when a **Product** is flagged as counterfeit.
5. Only users with the "Admin" role can resolve **Alerts**.