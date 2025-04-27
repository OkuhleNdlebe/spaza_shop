# Use Case Specifications

## Use Case 1: Verify Product Authenticity
**Actor**: Customer, Shop Owner

**Description**: This use case allows customers and shop owners to verify the authenticity of a product using a QR code scanner.

**Preconditions**:
- The customer or shop owner has access to a QR code scanner.
- The product has a QR code.

**Postconditions**:
- The system displays the product authenticity status.

**Basic Flow**:
1. The actor scans the QR code on the product.
2. The system retrieves the product details from the database.
3. The system verifies the authenticity of the product.
4. The system displays the authenticity status to the actor.

**Alternative Flows**:
- **QR Code Not Found**: If the QR code is not found in the database, the system displays an error message indicating that the product cannot be verified.

## Use Case 2: Alert Product Expiry
**Actor**: Shop Owner

**Description**: This use case alerts shop owners about upcoming product expiry dates.

**Preconditions**:
- The shop owner is registered in the system.

**Postconditions**:
- The shop owner receives an alert about products nearing their expiration date.

**Basic Flow**:
1. The system checks the expiry dates of products in the inventory.
2. The system identifies products that will expire in the next 30 days.
3. The system sends an alert to the shop owner.

**Alternative Flows**:
- **No Products Nearing Expiry**: If there are no products nearing their expiry date, the system does not send any alerts.

## Use Case 3: Report Counterfeit Product
**Actor**: Environmental Health Professional

**Description**: This use case allows environmental health professionals to report counterfeit products.

**Preconditions**:
- The environmental health professional is logged into the system.

**Postconditions**:
- The counterfeit product report is logged in the system.

**Basic Flow**:
1. The actor selects the option to report a counterfeit product.
2. The actor enters the product details, shop details, and uploads photographic evidence.
3. The system logs the report and sends a notification to the regulator.

**Alternative Flows**:
- **Incomplete Report**: If the report is incomplete, the system prompts the actor to provide the missing information.

## Use Case 4: Provide Customer Feedback
**Actor**: Customer

**Description**: This use case allows customers to provide feedback on product quality.

**Preconditions**:
- The customer has purchased the product.
- The customer is logged into the system.

**Postconditions**:
- The feedback is recorded in the system.

**Basic Flow**:
1. The customer selects the option to provide feedback.
2. The customer enters feedback details and submits the form.
3. The system acknowledges the feedback submission.
4. The system records the feedback.

**Alternative Flows**:
- **Feedback Submission Failure**: If the feedback submission fails, the system displays an error message and prompts the customer to try again.

## Use Case 5: Access Educational Resources
**Actor**: Customer, Environmental Health Professional

**Description**: This use case allows users to access educational resources about counterfeit products.

**Preconditions**:
- The user is logged into the system.

**Postconditions**:
- The user accesses the educational resources.

**Basic Flow**:
1. The user selects the option to access educational resources.
2. The system displays a list of available resources.
3. The user selects a resource to view.
4. The system displays the selected resource.

**Alternative Flows**:
- **Resource Not Found**: If the selected resource is not found, the system displays an error message.

## Use Case 6: Monitor Compliance
**Actor**: Regulator

**Description**: This use case allows regulators to monitor compliance of stores and manufacturers.

**Preconditions**:
- The regulator is logged into the system.

**Postconditions**:
- The regulator views compliance reports.

**Basic Flow**:
1. The regulator selects the option to monitor compliance.
2. The system retrieves compliance data from the database.
3. The system generates a compliance report.
4. The system displays the compliance report to the regulator.

**Alternative Flows**:
- **No Compliance Data**: If there is no compliance data available, the system displays a message indicating that there are no reports to show.

## Use Case 7: Manage Inventory
**Actor**: Shop Owner

**Description**: This use case allows shop owners to manage their inventory levels, track sales, and monitor expired products.

**Preconditions**:
- The shop owner is logged into the system.

**Postconditions**:
- The inventory is updated in the system.

**Basic Flow**:
1. The shop owner selects the option to manage inventory.
2. The shop owner adds, updates, or removes product details.
3. The system updates the inventory in real-time.
4. The system displays the updated inventory to the shop owner.

**Alternative Flows**:
- **Inventory Update Failure**: If the inventory update fails, the system displays an error message and prompts the shop owner to try again.

## Use Case 8: Secure Login
**Actor**: Customer, Shop Owner, Regulator, Developer, Environmental Health Professional

**Description**: This use case ensures secure login for all user roles using multi-factor authentication (MFA).

**Preconditions**:
- The user has an active account in the system.

**Postconditions**:
- The user is logged into the system.

**Basic Flow**:
1. The user enters their username and password.
2. The system sends a verification code to the user's registered device.
3. The user enters the verification code.
4. The system verifies the code and logs the user into the system.

**Alternative Flows**:
- **Invalid Credentials**: If the user enters invalid credentials, the system displays an error message and prompts the user to try again.
- **Verification Code Failure**: If the verification code is incorrect or not entered within the time limit, the system displays an error message and prompts the user to request a new code.