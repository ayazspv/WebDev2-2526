# Frontend

A Vue 3 application built with Vite and Fontawesome.

## 🚀 Tech Stack

- **Vue 3** - Progressive JavaScript framework
- **Vite** - Frontend build tool
- **Fontaesome CSS** - CSS framework

## 📁 Project Structure

Here below is the project architecture

```
src/
├── assets/                   # Global styles and assets
│   └── main.css              # Fontawesome CSS import
├── components/               # Component library
│   ├── Admin/                # Admin related components
│   ├── Auth/                 # Authentication pages components
│   ├── Cart/                 # SHpping card components
│   ├── Home/                 # Home page components
│   └── Layout/               # Differente layout templates
│   ├── Materials/            # Material related components
│   ├── User/                 # User side components
├── router/                   # Application configuration
│   └── index.js              # Main page routing fucntion
├── stores/                   # Application configuration
│   └── cartStore.js          # Cart API pinia store
│   └── materialStore.js      # Material API pinia store
│   └── orderStore.js         # Order API pinia store
│   └── userStore.js          # User API pinia store
├── views/                    # Application public pages
│   └── 404.vue               # 404 not found page
│   └── Home.vue              # Home page
│   └── MaterialDetail.vue    # Material detail page
│   └── Materials.vue         # Material page
└── App.vue                   # Application entry point
└── axios.js                  # Main API entry point
└── main.js                   # Main javascript functions
```

## 🛠️ Setup

### Prerequisites

- Node.js ^20.19.0 or >=22.12.0
- npm or yarn

### Installation

```sh
npm install
```

## 🎯 Available Scripts

### Development

```sh
# Start development server
npm run dev

### Production

```sh
# Build for production
npm run build

# Preview production build
npm run preview
