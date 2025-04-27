# Agile Planning Document

## Introduction
This document compiles all artifacts related to the Agile planning process for the SpazaSafe project. It includes user stories derived from functional requirements, a product backlog with MoSCoW prioritization, sprint planning details, and a reflection on the challenges encountered during the translation of requirements to use cases and tests.

## User Stories

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

### Non-Functional User Stories

| Story ID | User Story | Acceptance Criteria | Priority (High/Medium/Low) |
|----------|------------|---------------------|----------------------------|
| US-NF-001| As a system admin, I want user data encrypted with AES-256 so that security compliance is met. | All user data is encrypted using AES-256 encryption. | High |
| US-NF-002| As a performance tester, I want the system to handle 1,000 concurrent users so that it performs well under high load. | The system response time is ≤ 2 seconds for 1,000 concurrent users. | High |

## Product Backlog

| Story ID | User Story | Priority (MoSCoW) | Effort Estimate (Story Points) | Dependencies |
|----------|------------|-------------------|--------------------------------|--------------|
| US-001   | As a customer, I want to scan QR codes to verify product authenticity so that I can ensure the products I purchase are genuine. | Must-have | 3 | None |
| US-002   | As a shop owner, I want to receive alerts about products nearing their expiry date so that I can remove them from inventory in time. | Must-have | 2 | None |
| US-003   | As an environmental health professional, I want to report counterfeit products so that regulators can take action against counterfeit goods. | Must-have | 3 | None |
| US-004   | As a customer, I want to provide feedback on product quality so that manufacturers can improve their products. | Should-have | 2 | None |
| US-005   | As a customer, I want to access educational resources about counterfeit products so that I can learn how to identify them. | Should-have | 2 | None |
| US-006   | As a regulator, I want to monitor compliance of stores and manufacturers so that I can ensure health regulations are followed. | Must-have | 4 | None |
| US-007   | As a shop owner, I want to manage my inventory levels so that I can keep track of product sales and monitor expired products. | Must-have | 3 | None |
| US-008   | As a developer, I want to maintain an audit trail of all transactions and activities so that the system's integrity is ensured. | Should-have | 3 | None |
| US-009   | As a customer, I want to securely log in using multi-factor authentication so that my account is protected from unauthorized access. | Must-have | 3 | None |
| US-010   | As a regulator, I want to generate data analytics on product sales and counterfeit incidents so that I can make informed decisions. | Should-have | 4 | None |
| US-011   | As a shop owner, I want to register new products by scanning their QR codes so that my inventory is updated quickly. | Must-have | 2 | None |
| US-012   | As a regulator, I want to send alerts and notifications about non-compliance and counterfeit reports so that shop owners and manufacturers are informed. | Must-have | 3 | None |
| US-NF-001| As a system admin, I want user data encrypted with AES-256 so that security compliance is met. | Must-have | 3 | None |
| US-NF-002| As a performance tester, I want the system to handle 1,000 concurrent users so that it performs well under high load. | Must-have | 4 | None |

### Justification for Prioritization

#### Must-have Stories
Must-have stories align with stakeholder success metrics for usability and security. These are critical functionalities that ensure the basic operation and security of the system. Without these, the system would fail to meet its primary objectives and user expectations. For example, verifying product authenticity (US-001) and receiving alerts about product expiry (US-002) are essential for maintaining trust and safety in the product supply chain.

#### Should-have Stories
Should-have stories add significant value to the system but are not critical for its basic operation. They enhance the user experience and provide additional functionalities that improve overall satisfaction. For instance, providing feedback on product quality (US-004) and accessing educational resources (US-005) help in creating a more engaging and informative user experience.

#### Could-have Stories
Could-have stories are not included in this backlog as they are considered nice-to-have features that can be deferred until later phases of the project if time and resources permit.

#### Won’t-have Stories
Won’t-have stories are features that have been explicitly excluded from the current project scope. These might be revisited in future iterations or versions based on evolving stakeholder needs and feedback.

## Sprint Planning

### Sprint Goal
Implement core product verification and alert functionalities to ensure customer safety and trust.

### Selected User Stories for Sprint

1. **US-001**: As a customer, I want to scan QR codes to verify product authenticity so that I can ensure the products I purchase are genuine.
2. **US-002**: As a shop owner, I want to receive alerts about products nearing their expiry date so that I can remove them from inventory in time.
3. **US-003**: As an environmental health professional, I want to report counterfeit products so that regulators can take action against counterfeit goods.
4. **US-006**: As a regulator, I want to monitor compliance of stores and manufacturers so that I can ensure health regulations are followed.
5. **US-011**: As a shop owner, I want to register new products by scanning their QR codes so that my inventory is updated quickly.

### Sprint Backlog

| Task ID | Task Description | Assigned To | Estimated Hours | Status (To Do/In Progress/Done) |
|---------|------------------|-------------|-----------------|---------------------------------|
| T-001   | Develop QR code scanning API endpoint | Dev Team | 8 | To Do |
| T-002   | Implement product authenticity verification logic | Dev Team | 10 | To Do |
| T-003   | Create UI for QR code scanning and product verification | Frontend Team | 12 | To Do |
| T-004   | Develop alert system for product expiry | Dev Team | 8 | To Do |
| T-005   | Design UI for alert notifications | Frontend Team | 8 | To Do |
| T-006   | Implement counterfeit product reporting feature | Dev Team | 10 | To Do |
| T-007   | Create UI for counterfeit product reporting | Frontend Team | 10 | To Do |
| T-008   | Develop compliance monitoring dashboard | Dev Team | 12 | To Do |
| T-009   | Design UI for compliance monitoring | Frontend Team | 10 | To Do |
| T-010   | Implement product registration feature via QR code scanning | Dev Team | 8 | To Do |
| T-011   | Create UI for product registration | Frontend Team | 10 | To Do |

### Sprint Goal Statement
This sprint aims to implement core functionalities essential for verifying product authenticity, alerting shop owners about product expiry, reporting counterfeit products, and monitoring compliance. By achieving these goals, we ensure that the SpazaSafe system provides immediate value in terms of customer safety and regulatory compliance, contributing significantly to the Minimum Viable Product (MVP).

## Reflection on Challenges

### Challenges in Translating Requirements to Use Cases and Tests

- **Understanding Stakeholder Requirements**: One of the primary challenges was gaining a clear and comprehensive understanding of stakeholder requirements. Stakeholders often had diverse and sometimes conflicting needs, resulting in ambiguous or incomplete requirements.
- **Defining Clear and Concise Use Cases**: Another significant challenge was defining use cases that were clear, concise, and comprehensive. Overly complex use cases were difficult to implement and test, while overly simplistic use cases missed critical functionality.
- **Identifying All Possible Scenarios**: Ensuring that all possible scenarios were identified and documented in the use cases was crucial. Missing scenarios led to gaps in the system's functionality and unexpected behavior during operation.
- **Writing Effective Test Cases**: Translating use cases into effective test cases was critical for validating the system's functionality. However, writing test cases that covered all possible scenarios and edge cases was challenging.
- **Balancing Functional and Non-Functional Requirements**: Balancing functional and non-functional requirements in use cases and tests was essential. Both were equally important for the system's success.
- **Maintaining Consistency and Traceability**: Maintaining consistency and traceability between requirements, use cases, and tests was crucial for successful project delivery. Inconsistencies led to misunderstandings, missed requirements, and defects.

### Solutions

- **Continuous Communication**: Engaging in continuous communication with stakeholders through workshops, interviews, and surveys helped gather detailed requirements and ensure clarity.
- **Structured Approach**: Adopting a structured approach to writing use cases, including defining the use case title, description, actors, preconditions, postconditions, basic flow, and alternative flows, ensured clarity and completeness.
- **Comprehensive Documentation**: Creating comprehensive activity diagrams and flowcharts visualized all possible interactions and scenarios, uncovering overlooked scenarios.
- **Systematic Test Case Writing**: Following a systematic approach to writing test cases, including defining the test case ID, description, preconditions, steps, expected result, and actual result, ensured comprehensive coverage.
- **Explicit Non-Functional Requirements**: Explicitly defining non-functional requirements and including them in the use cases and tests ensured that performance, security, usability, and reliability were consistently met.
- **Requirement Management Tools**: Using requirement management tools maintained consistency and traceability, linking requirements to use cases and test cases, ensuring all requirements were addressed.

## Conclusion
This Agile Planning Document provides a comprehensive overview of the planning process for the SpazaSafe project, including user stories, product backlog, sprint planning, and a reflection on challenges encountered. By following a structured approach and addressing the identified challenges, the team can ensure that the system meets stakeholder expectations and functions correctly.