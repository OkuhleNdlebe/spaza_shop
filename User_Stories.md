# User Stories

| Story ID | User Story | Acceptance Criteria | Priority (High/Medium/Low) |
|----------|------------|---------------------|----------------------------|
| US-001   | As a customer, I want to scan QR codes to verify product authenticity so that I can ensure the products I purchase are genuine. | The system displays product authenticity status within 1 second after scanning the QR code. | High |
| US-002   | As a shop owner, I want to receive alerts about products nearing their expiry date so that I can remove them from inventory in time. | Alerts are sent to the shop owner 30 days before product expiry. | High |
| US-003   | As an environmental health professional, I want to report counterfeit products so that regulators can take action against counterfeit goods. | The report is logged and a notification is sent to the regulator within 1 hour of submission. | High |
| US-004   | As a customer, I want to provide feedback on product quality so that manufacturers can improve their products. | Feedback submission is acknowledged within 24 hours, and feedback is recorded in the system. | Medium |
| US-005   | As a customer, I want to access educational resources about counterfeit products so that I can learn how to identify them. | Educational resources are accessible online and can be viewed without any errors. | Medium |
| US-006   | As a regulator, I want to monitor compliance of stores and manufacturers so that I can ensure health regulations are followed. | Compliance reports are generated and displayed accurately. | High |
| US-007   | As a shop owner, I want to manage my inventory levels so that I can keep track of product sales and monitor expired products. | Inventory is updated in real-time and accurately reflects the current stock. | High |
| US-008   | As a developer, I want to maintain an audit trail of all transactions and activities so that the system's integrity is ensured. | Audit trail includes timestamps, user IDs, and action details for all activities. | Medium |
| US-009   | As a customer, I want to securely log in using multi-factor authentication so that my account is protected from unauthorized access. | The system enforces MFA and requests a verification code for each login attempt. | High |
| US-010   | As a regulator, I want to generate data analytics on product sales and counterfeit incidents so that I can make informed decisions. | Analytics reports are available for download in CSV format. | Medium |
| US-011   | As a shop owner, I want to register new products by scanning their QR codes so that my inventory is updated quickly. | Product registration is completed within 2 seconds of scanning the QR code. | High |
| US-012   | As a regulator, I want to send alerts and notifications about non-compliance and counterfeit reports so that shop owners and manufacturers are informed. | Alerts are sent via email and SMS within 5 minutes of detection. | High |

## Non-Functional User Stories

| Story ID | User Story | Acceptance Criteria | Priority (High/Medium/Low) |
|----------|------------|---------------------|----------------------------|
| US-NF-001| As a system admin, I want user data encrypted with AES-256 so that security compliance is met. | All user data is encrypted using AES-256 encryption. | High |
| US-NF-002| As a performance tester, I want the system to handle 1,000 concurrent users so that it performs well under high load. | The system response time is ≤ 2 seconds for 1,000 concurrent users. | High |