# 🌦️ SkyCast — Weather Dashboard v1.0

SkyCast is a modern weather dashboard built with Symfony that provides real-time weather data, interactive maps, and a clean UI experience. It focuses on dynamic UX, fast responses, and modular architecture using Symfony components.

---

🌤️ Check out Weather Dashboard!
You can check it out here:
👉 https://skycast-uqyk.onrender.com/

⚠️ Note on Loading: The application is hosted on Render's free tier. If the link takes about a minute to load initially, that is completely normal! The server automatically "spins down" when inactive and needs around 50–60 seconds to wake up and handle the first request. Once it's awake, it runs smoothly!



## 🚀 Features (Current Version)

### 🌍 Interactive Weather Map
- Symfony UX Map (Leaflet-based)
- Click-to-select location
- Draggable marker support
- Controlled zoom behavior (no auto over-zoom)
- Dynamic map rendering inside dashboard cards

---

### 🌦️ Weather Data System
- Current weather conditions (temperature, humidity, wind, pressure)
- 5-day forecast display
- Weather descriptions and icons
- “Feels like” temperature
- Structured API responses via DTOs

---

### 📡 External API Integrations
SkyCast integrates multiple third-party services:

- Open-Meteo Weather API (current + forecast + hourly data)
- Open-Meteo Geocoding API (city search)
- Reverse geocoding (fallback provider support for coordinates → city name)

---

### ⚙️ Backend Architecture
- Symfony Controllers handle request flow
- Service layer for weather & geocoding logic
- DTOs for clean API response mapping
- Validation for search inputs
- Modular separation of concerns

---

### ⚡ Frontend Interaction
- Turbo Frames for partial page updates (no full reloads)
- Stimulus controllers for map interaction
- AJAX-like behavior via Symfony UX / Turbo
- Dynamic marker updates
- Real-time coordinate syncing between UI and backend

---

### 🎨 UI / UX Design
- Dark modern dashboard theme
- Glassmorphism-style cards
- Responsive grid layout
- Smooth hover animations
- Clean forecast visualization cards
- Integrated map inside weather view

---

## 🗺️ Map System
- Leaflet-based interactive map
- Marker placement on click
- Marker drag support
- Controlled zoom (fixed zoom levels for stability)
- Center synchronization with selected city

---

## 🔄 Application Flow

User Action → System Flow:

1. User searches city OR clicks map
2. Controller receives coordinates or city name
3. Geocoding service resolves location
4. Weather service fetches API data
5. DTO structures the response
6. Twig renders dashboard UI
7. Turbo Frame updates only necessary section

---

## 🧠 Core Concepts Used

- DTO pattern for clean data handling
- Service-oriented architecture
- Separation of UI and business logic
- Reactive UI updates (no full page reloads)
- Symfony UX ecosystem integration
- Minimal JavaScript approach (Stimulus only where needed)

---

## 📦 Planned Features

### 🌦️ Hourly Forecast Expansion
- Click on a daily forecast card
- Expand into hourly breakdown view
- Smooth UI animations (accordion/drawer style)
- Uses already-fetched hourly API data (no extra requests)

---

### 👤 Authentication System
- User registration & login
- Personal dashboard per user
- Save favorite cities
- Tag system for locations (e.g. Home, Work, Travel)
- Watchlist for weather monitoring

---

### 📍 GPS Location Feature
- Detect user location on landing page
- Automatically load nearest weather station
- Permission-based geolocation
- Fallback to manual search or map selection

Recommended UX placement:
- GPS feature integrated into landing page as primary CTA:
  “Get weather near you instantly”

---

### ⚡ Performance Improvements
- Redis caching layer (15 min TTL)
- Grid-based caching for coordinates
- Reduced API calls via caching strategy
- Faster repeated searches for same locations

---

### 📊 Future Enhancements
- Hourly temperature graphs (Chart.js)
- Weather alerts system (storm/rain warnings)
- Multi-city comparison view
- Saved location dashboard
- Animated weather transitions

---

## 🧪 Project Status

Version: v1.0 (MVP+)

- Weather dashboard fully functional
- Interactive map system implemented
- API integrations working
- Turbo Frame dynamic updates
- Clean UI/UX implemented
- DTO-based backend architecture

---

## 🛠 Installation

```bash
composer install
npm install
npm run dev
symfony server:start