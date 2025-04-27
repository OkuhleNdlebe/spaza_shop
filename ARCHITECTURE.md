# ARCHITECTURE.md

## 1. Project Title
**SpazaSafe: Counterfeit & Expired Product Detection System**

## 2. Domain
**Informal Retail & Consumer Safety**  
SpazaSafe operates within the informal retail sector, aiming to enhance product authenticity and safety in Spaza shops across South Africa. The system integrates QR codes, suppliers, shop owners, and regulatory bodies to ensure safe and legitimate products are sold.

## 3. Problem Statement
Spaza shops often sell expired or counterfeit products due to weak supply chain transparency. Consumers face health risks, and legitimate suppliers lose revenue. SpazaSafe addresses this issue by providing QR-based product authentication, supplier verification, and regulatory tracking.

## 4. C4 Architectural Diagrams

### 4.1 Context Diagram
Illustrates how SpazaSafe interacts with different users and external systems.

```mermaid
flowchart TB
  A[Spaza Shop Owner] -->|Scans QR Codes| B[SpazaSafe System]
  C[Consumer] -->|Scans QR Codes| B
  D[Supplier] -->|Registers Products| B
  E[Regulator] -->|Audits Compliance| B
  B -->|Provides Authentication| C
```

### 4.2 Container Diagram
Breaks the system into major components (backend, frontend, database, integrations).

```mermaid
flowchart TB
  subgraph Frontend
    A[React/Vue Web App]
  end
  
  subgraph Backend
    B[Laravel API]
    C[Authentication Service]
    D[Product Verification Service]
    E[Delivery Tracking Service]
    F[QR Code Service]
  end
  
  subgraph Database
    G[MySQL Database]
  end
  
  subgraph External Services
    H[QR Code API]
  end

  A -->|API Requests| B
  B -->|Reads/Writes Data| G
  B -->|QR Code Validation| H
  B --> C
  B --> D
  B --> E
  B --> F
```

### 4.3 Component Diagram
Details key components within the system.

```mermaid
flowchart TB
  subgraph Backend
    A[Laravel API]
    B[Auth Controller]
    C[Product Controller]
    D[QR Code Controller]
    E[Delivery Controller]
  end
  
  subgraph Services
    F[Authentication Service]
    G[Product Verification Service]
    H[QR Code Processing Service]
    I[Delivery Tracking Service]
  end
  
  A --> B
  A --> C
  A --> D
  A --> E
  
  B --> F
  C --> G
  D --> H
  E --> I
```

### 4.4 Code Diagram (Level 4 - Code Structure)
Defines high-level structure for Laravel application.

```mermaid
flowchart TB
  subgraph Laravel Application
    A[Routes]
    B[Controllers]
    C[Models]
    D[Middleware]
    E[Services]
    F[Database Migrations]
  end
  
  subgraph Controllers
    G[AuthController]
    H[ProductController]
    I[QRController]
    J[DeliveryController]
  end
  
  subgraph Services
    K[Auth Service]
    L[Product Service]
    M[QR Code Service]
    N[Delivery Service]
  end
  
  A --> B
  B --> C
  B --> D
  B --> E
  E --> K
  E --> L
  E --> M
  E --> N
  C --> F
```

---
