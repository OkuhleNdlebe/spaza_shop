# Test Case Development

## Functional Test Cases
| Test Case ID | Requirement ID | Description | Steps | Expected Result | Actual Result | Status (Pass/Fail) |
|-------------|---------------|-------------|-------|----------------|--------------|------------------|
| TC-001 | FR-001 | Verify product authenticity using QR code scanner | 1. Open QR scanner<br>2. Scan product QR code | Product authenticity status displayed within 1 second | | |
| TC-002 | FR-002 | Alert shop owners about upcoming product expiry dates | 1. Add products with expiry dates<br>2. Wait for 30-day threshold | Expiry alert generated at least 30 days before expiry | | |
| TC-003 | FR-003 | Report counterfeit product | 1. Enter product details<br>2. Attach photos<br>3. Submit report | Report successfully submitted and stored | | |
| TC-004 | FR-004 | Customers provide feedback on product quality | 1. Open feedback form<br>2. Submit feedback | Acknowledgment within 24 hours | | |
| TC-005 | FR-005 | Access educational resources on counterfeit products | 1. Open resources section<br>2. Click article link | Resource content displayed successfully | | |
| TC-006 | FR-006 | Generate compliance reports | 1. Log in as regulator<br>2. Open compliance section | Monthly compliance report displayed | | |
| TC-007 | FR-007 | Shop owner manages inventory | 1. Add product<br>2. Check inventory updates | Inventory updated in real-time | | |
| TC-008 | FR-008 | Send alerts about counterfeit reports | 1. Detect counterfeit<br>2. Send alert | Alert sent via email/SMS within 5 minutes | | |

## Non-Functional Test Cases
| Test Case ID | Requirement ID | Description | Steps | Expected Result | Actual Result | Status (Pass/Fail) |
|-------------|---------------|-------------|-------|----------------|--------------|------------------|
| NTC-001 | NFR-001 (Performance) | System handles 1,000 concurrent users verifying products | 1. Simulate 1,000 users scanning QR codes | Response time ≤ 2 seconds for each request | | |
| NTC-002 | NFR-002 (Security) | Multi-factor authentication (MFA) for login | 1. Attempt login with username/password<br>2. Enter MFA code | Only authorized users gain access | | |

## Notes
- "Actual Result" and "Status" columns will be updated after testing.
- Non-functional tests include **performance testing** and **security validation**.

---

**Author:** Okuhle Ndlebe  
**Date:**  13 March 2025
