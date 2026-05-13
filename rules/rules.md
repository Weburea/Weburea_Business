# Weburea Project Standards & Rules

This document serves as the primary technical and design authority for the Weburea Agency project. All future development must adhere to these standards to maintain consistency, security, and premium aesthetics.

## 1. UI/UX & Feedback Systems

### Notifications (Toasts)
- **Mandatory Helper**: All status updates, form submissions, and error messages **MUST** use the centralized `Weburea Toast System`.
- **Implementation**: Call `showToast(message, type)` where type is `success`, `danger`, `warning`, or `info`.
- **Bootstrap Integration**: Ensure `inject_toast_system()` is called at the end of the file.
- **Rule**: Do not create local alert containers or use standard "box square" Bootstrap alerts.

### Modal Design (Premium Aesthetic)
- **Visual Style**: Modals must use the "Midnight Blue & Orange" premium theme.
- **Header**: Must feature a gradient background (e.g., `bg-dark-blue`) with a `frosted-icon-circle`.
- **Delete Modals**: **Mandatory Pattern:** All destructive actions (deleting reviews, benefits, or components) MUST use the `'dark'` version of the `showPremiumDeleteModal`. This replaces the standard red/danger style to maintain a more sophisticated, "Security Protocol" feel.
- **Universal Alerts**: **Mandatory Pattern:** For all non-destructive feedback (success, info, errors), use the `showPremiumAlert(title, message, type, btnText)` helper. 
    - **Types**: `success` (Green), `danger/error` (Red), `warning` (Orange), `info` (Blue).
    - **Rule**: For "Limit Reached" notifications or general informational constraints, always use the `'info'` type to ensure a professional, non-alarming aesthetic.
    - **Bootstrap Integration**: Ensure `inject_premium_alert_modal()` is called at the end of the file.
- **Layout**: Modals should be optimized to fit within `100vh`. Use `modal-dialog-scrollable` for long forms.
- **Typography**: Labels must be small, bold, and uppercase with `letter-spacing: 1px`.
- **Accent**: Use the Weburea orange for primary actions and "Verified Secure" footers.

### Custom Selectors (Premium Dropdowns)
- **Mandatory Helper**: Standard `<select>` elements **MUST** be replaced with the `renderPremiumSelect` system.
- **Global Availability**: Logic is centralized in `dashboard/assets/js/functions.js` and styles in `dashboard/assets/css/dashboard.css`.
- **Implementation Rules**:
    - **Container**: Use a placeholder `div` with a unique ID (e.g., `id="my-select-container"`).
    - **Trigger**: Initialize with `renderPremiumSelect(containerID, options[], currentValue, onChangeCallback)`.
    - **Dynamic Content**: When rendering rows via JS, re-initialize the select for each row after appending to the DOM.
    - **Design Integrity**: Custom dropdowns must handle icon/image prefixes to maintain the high-fidelity aesthetic.
    - **Rule**: Standard Bootstrap `.form-select` is deprecated for high-visibility admin controls.

## 2. Architecture & Security

### Authentication
- **Admin Protection**: All administrative dashboard files **MUST** include `require_once('../include/auth_check.php');` at the very beginning.
- **Session Integrity**: Session status checks are handled globally in the auth and alert includes.

### API Standards
- **Endpoint Location**: All backend logic for frontend or dashboard interaction must reside in the `/api` directory.
- **Security Locking**: All API endpoints must enforce:
    - **Session Validation**: Check if the user is logged in.
    - **Header Verification**: Check for the `X-API-Key` (e.g., `weburea_secret_2026`).
- **Postman Integration**: Endpoints must be formatted to return standard JSON for external testing and integration.
- **Non-Destructive Architecture (Soft Deletes)**:
    - **Rule**: Administrative APIs **MUST NOT** perform permanent `DELETE` operations on core database records. 
    - **Implementation**: Use `UPDATE table SET status = 'archived' WHERE id = ?` instead of `DELETE`.
    - **Postman Testing**: This allows developers to test "Delete" functionality in Postman without actually losing sample data.
    - **Integrity**: Always verify `rowCount() > 0` and return `404 Not Found` if the ID does not exist or is already archived.
- **UPDATE/PUT Operations**: Must differentiate between "Successful Update" and "No Changes Made" (if record exists but data is identical) versus "404 Not Found" (if ID doesn't exist).
- **Postman Mock Testing Mode**:
    - **Rule**: All state-modifying endpoints (`POST`, `PUT`, `DELETE`) **MUST** support a non-destructive mock testing mode when accessed via `X-API-Key` without an active dashboard session.
    - **Implementation**: Use `$isApiTest = !isset($_SESSION['user_id']);`. When true, bypass `PDO` executions and media manipulation, returning a `200 OK` simulated success JSON payload instead.

## 3. Data & Database Management

### SQL Staging
- **Source of Truth**: All schema modifications, table creations, or seed data updates must first be written as `.sql` files in the `/sql` directory.
- **Idempotency**: SQL files should include `TRUNCATE TABLE` or `IF NOT EXISTS` logic to prevent duplication during re-imports.
- **Deployment**: Never modify the database structure directly through a tool without committing a corresponding SQL script to the `/sql` folder first.

### File Naming & Structure
- **PHP First**: All dynamic pages must use the `.php` extension. Static `.html` files in the dashboard or main routes are deprecated.
- **Modular Includes**: Reusable UI components (header, footer, alerts) must be placed in the `/include` directory.

## 4. Color Concept & Tokens
- **Midnight Blue (Backgrounds/Headers)**: `linear-gradient(135deg, #1e293b 0%, #0f172a 100%)`
- **Weburea Orange (Buttons/Badges)**: `#F48C06` to `#E85D04`
- **Glassmorphism**: Use `backdrop-filter: blur(12px)` and semi-transparent borders for premium elements.

## 5. Dashboard Home Page Design Concept
- **Global Stylsheet Override**: **All custom dashboard CSS MUST be placed in `assets/css/dashboard.css`.** Do not use inline `<style>` tags directly within any dashboard templates to maintain absolute architecture consistency and code modularity.
- **Storage Widget**: Features a `linear-gradient(45deg, #1e293b, #334155)` background, a `bg-primary` pill badge for file counts, and a neon blue progress bar track (`#3b82f6` to `#60a5fa`).
- **Dynamic Monitoring**: All dashboard storage indicators **MUST** synchronize with `api/media-manager.php?action=report`. The UI must refresh automatically (via `updateStorageReport()`) after every successful media upload or section save to provide real-time feedback on system capacity.
- **Dashboard Cards (`.home-card`)**: Must use standard body background with an outer border (`0.1` opacity primary) and `0 10px 30px rgba(0, 0, 0, 0.05)` shadow.
- **Section Headers (`.section-header`)**: Uses a `48x48` icon box with a subtle `0.1` primary color background for icon encapsulation, alongside a bottom border divider. The `<h4/>` section text should properly inherit `--bs-heading-color` to display cleanly on both light and dark backgrounds.
- **Navigation Tabs (`.premium-nav-tabs`)**: The standard for sub-navigation in the dashboard. Features a rounded background container (`#f1f5f9` light, `#334155` dark) with rounded pill-style links (`.nav-link`). The `.active` tab must use the Weburea primary color (`#F48C06`). Always use `nav nav-tabs premium-nav-tabs` structure and semantic `data-bs-toggle="tab"` attributes.
- **Gallery Grid (`.gallery-grid`)**: `auto-fill`, `minmax(180px, 1fr)` structure. Images (`.gallery-item`) use `16/9` ratio, with distinct hover overlays mapping to view/remove actions (e.g., standard red remove button).
- **Stat Inputs (`.stat-input-row`)**: Background is subtle (`0.02` secondary opacity) with a light internal border to organize grouped metadata fields.

## 6. Premium Table System
- **Mandatory Helper**: Dashboard tables **MUST** apply the `.table-premium` class and be wrapped in a `.table-responsive` container.
- **Design Specifications**:
    - **Aesthetics**: Rows must have rounded corners (`border-radius: 12px`), separate borders, and subtle lift shadows on hover.
    - **Responsiveness**: Enforce a `min-width` on the table itself to trigger horizontal scrolling on mobile, preventing content scattering.
    - **Header Style**: Use uppercase, bold typography with specific width tokens for desktop alignment.
- **Rule**: Do not use standard Bootstrap `.table` without the `.table-premium` overrides for main administrative lists.

### Section 7: Modern Z-Index & Stacking
- **Stacking Logic:** Any parent container (row/card) containing a `premium-select` MUST boost its `z-index` when the select is active.
- **Implementation:** Use `:has(.premium-select-wrapper.active)` in CSS and explicit JS `zIndex` manipulation in `functions.js`.

## 8. Social Media Platform Selectors
- **Dropdown Standard:** Never use text inputs for social media icon classes. Always use the `renderPremiumSelect` system with pre-defined platform maps (Instagram, Facebook, LinkedIn, TikTok, X, WhatsApp).
- **Icon Prefixing:** Selected values must be stored with the `bi ` prefix (e.g., `bi bi-facebook`) to ensure compatibility with frontend Bootstrap Icon rendering.
- **Column Width:** Social Platform Selectors should optimally occupy `180px` on desktop headers.

## 9. Media Upload Triggers
- **Mandatory Pattern:** Any interactive element that triggers a media selector (avatars, icons, logos) **MUST** apply the `.avatar-clickable` standard for visual feedback.
- **Visual Feedback:** 
    - **Overlay**: On hover, the element must show an orange-tinted overlay (`rgba(244, 140, 6, 0.6)`) with a camera icon (`bi-camera`).
    - **Animation**: The element must scale up slightly (`1.08`) using a smooth cubic-bezier transition.
- **Implementation**:
    - Classes: Use `.avatar.avatar-clickable` for standard profile-style images or `.avatar-clickable` for custom boxes.
    - Consistency: Ensure all media triggers across the dashboard follow this pattern to maintain high-fidelity user intuition.

## 10. Development & Communication Workflow
- **No Online Demos / Scatterpad**: **DO NOT** use, display, or attempt to demo features via "Scatterpad" or any online preview tool. Once implementation is complete, proceed directly to confirming the project state. The user will handle all demonstrations and visual verifications personally.
- **Rule Enforcement**: This rule applies to all future iterations and feature updates within the Weburea Agency scope. Any mention of "Scatterpad" as a task for the AI is strictly prohibited.


## 11. Global Dashboard Aesthetics & Layout
- **Style Centralization**: **All custom dashboard CSS MUST be placed in `assets/css/dashboard.css`.** Do not use inline `<style>` tags directly within any dashboard templates.
- **Premium Color Selector**: For choosing text highlight colors (e.g., hero titles), always use the `renderColorSelect` helper which maps CSS color classes (e.g., `text-primary`) to visual color previews using `bi-circle-fill` icons for a high-fidelity aesthetic consistent with the platform standard.
- **Responsive Grid Patterns**:
    - **Avatar Grids**: Always use `grid-template-columns` with media query overrides to prevent items from overflowing ("shooting outside") on mobile devices. 
    - **Standard Mapping**: 5 columns on desktop, 3 columns on tablet (max-width: 768px), 2 columns on small mobile (max-width: 480px).

## 12. Resource Management & AI Workflow
- **Scratchpad Usage**: The AI scratchpad is strictly **DISABLED** for this project to optimize system performance and save RAM. 
- **Implementation Rule**: Do not use, create, or modify files in the `scratch/` directory. All temporary logic or investigative scripts must be handled within standard project files or terminal outputs.

### 13. Dynamic Premium Modal System
- **Centralized Configuration**: All user-facing modals (Success, Warning, Error, Delete) MUST be driven by the `modal_configurations` table.
- **Dynamic Content**: Never hardcode modal titles, messages, or button text. Use the `showPremiumAlert(title, message, type, buttonText, context)` function.
- **Contextual Awareness**: Always pass a `context` (e.g., 'contact', 'newsletter') to these functions. 
- **Context Selection Standards**:
    - **Dashboard Actions**: All destructive actions (deletions) and general dashboard feedback MUST use the 'global' context.
    - **Page-Specific Feedback**: Public-facing pages (e.g., Contact Page, Newsletter) MUST use their designated context (e.g., 'contact', 'newsletter') for form submissions and specific alerts.
- **Delete Confirmation**: Deletions MUST use `showPremiumDeleteModal(null, null, onConfirm, type, 'global')` within the dashboard to ensure consistency.
- **Administrative Control**:
    - **Location**: Use `dashboard/dashboard-modals.php` to manage configurations across different contexts.
    - **Custom Assets**: The system supports custom image paths per modal. Always verify the asset path (relative to site root) and preview it in the dashboard.
    - **Live Testing**: The dashboard **MUST** be used to live-test specific contexts before deployment.
- **Directional Animations**:
    - **Standard**: Success/Positive = `float-up`, Warning/Negative = `float-down`.
- **Dark Theme Integrity**: All premium modal components (headers, footers, bodies) MUST avoid hardcoded light backgrounds (e.g., `#fff` or `#f8fafc`) to ensure compatibility with the deep-navy dashboard aesthetic. Footers must remain transparent or use subtle dark glassmorphism.

## 14. Shared Component Management (Global Sync)
- **Concept**: Shared sections like `Reviews` and `CTA` that appear on multiple pages (e.g., Home and About) **MUST** consume data from a single source of truth.
- **Implementation**: The About page fetching logic must query the `homepage_sections` table for these keys to ensure that an update in the Home dashboard automatically reflects globally.
- **Design Standards**: Shared components must use the most high-fidelity version of the markup (e.g., Vertical Marquee for Reviews) regardless of the page they appear on.

## 15. Modular About Page Sectioning
- **Architecture**: The About page is built using modular includes located in `include/sections/about/*.php`.
- **Management**: Each section (Hero, Company Info, Mission/Vision, Team, Awards, History) has a dedicated management tab in `dashboard/dashboard-about.php`.
- **Asset Integrity**: Side illustrations and introductory graphics for these sections must be dynamic and manageable via the **Avatar Clickable** interface.

## 16. Dynamic Awards Intro & Achievements
- **Structure**: The "Awards" section is divided into two parts:
    - **Awards Intro**: The header section with big "Since [Year]" text, intro copy, and service list.
    - **Award Achievements**: The grid of icons and award labels.
- **Management**: Both parts are managed within the "Awards" tab in the dashboard. Intro list items must be comma-separated for simple management.
- **Aesthetic**: Maintain the `text-bg-img` class for the founding year to ensure the image-masking effect is preserved dynamically.

## 17. Structural Integrity & Template Synchronization
- **Source of Truth**: The `index-application-showcase.html` (or other provided showcase templates) serves as the primary reference for layout, section order, and asset arrangement.
- **Dual-Slider Synchronization**: Any UI component featuring dual linked sliders (e.g., Image + Content phases in "Steps") **MUST** be programmatically linked using the Swiper `controller` module.
- **Implementation**: After `functions.js` initializes the swipers, manually link them: `swiperA.controller.control = swiperB; swiperB.controller.control = swiperA;`.
- **Spacing Consistency**: Sections must strictly follow the `py-0`, `py-6`, `py-lg-8` and `max-width-1550` patterns established in the reference templates to ensure high-fidelity "floating card" aesthetics.
- **Touch Interaction**: Always ensure `simulateTouch` is enabled for linked swipers to support intuitive mobile navigation.

## 18. CSS Architecture & Internal Styles
- **No Internal CSS**: **DO NOT** use internal `<style>` tags in any `.php` or HTML files. This prevents code from becoming cramped and unmanageable.
- **Frontend Styles**: All frontend CSS updates MUST be placed in the main frontend CSS file (`assets/css/main.css`).
- **Dashboard/Backend Styles**: All dashboard-related CSS updates MUST be placed in the dashboard's specific CSS file (`dashboard/assets/css/dashboard.css`).
- **Strict Separation**: Maintain a strict separation of concerns; never mix frontend styles into dashboard stylesheets or vice versa.


## 19. Portfolio Management & Sequencing
- **Sorting Logic**: Portfolio items **MUST** follow a strict priority sequence to maintain high-fidelity layouts.
    - **Frontend Display**: Always `ORDER BY (sort_order = 0), sort_order ASC, id ASC`. This ensures unassigned projects (`0`) appear at the end of the list, while prioritized projects (`1, 2, 3...`) appear first.
- **Conflict Resolution (Automated Shifting)**: 
    - **Rule**: When a project's `sort_order` is updated manually in the dashboard, the system **MUST** automatically shift other projects to prevent priority duplicates.
    - **Implementation**: If a new `sort_order` > 0 is assigned, the API must increment the `sort_order` of all existing records that are greater than or equal to the new value.
- **Drag-and-Drop Synchronization**:
    - **Interactive Tool**: Use `SortableJS` for administrative reordering with the `.drag-handle` selector.
    - **Persistence**: Reordering operations must perform a bulk transactional `UPDATE` via the dedicated reordering endpoint.
    - **Feedback**: Every reorder or manual sequence change **MUST** trigger a `showToast` notification to confirm database persistence.

## 20. Service-Pricing Synchronization (Auto-Sync)
- **Concept**: Portfolio works are linked to services via `service_id`. The project details page (`work-view.php`) is designed to automatically render ALL pricing plans associated with that service.
- **Rule**: Manual selection of individual pricing plans for a project is deprecated. 
- **Implementation**: 
    - **Dashboard UI**: When a service is selected, the dashboard MUST display a "Pricing Synchronized" badge and inform the user that all plans for that service are now linked.
    - **Data Integrity**: The `pricing_id` field in `portfolio_works` should be set to `0` or `NULL` when auto-syncing, as the frontend logic primarily relies on `service_id` to fetch the full plan array.
    - **Visual Feedback**: Use the `bg-success-soft` badge with a checkmark icon to confirm the synchronization state in the administrative modal.

## 21. Dynamic Case Study Narrative
- **Requirement**: Portfolio project views (`work-view.php`) must never use hardcoded case study text.
- **Fields**:
    - **Overview**: Must pull from `project_overview` (fallback to `description`).
    - **The Challenge**: Must pull from `project_challenge`.
    - **Challenge Points**: Must pull from `challenge_points` (newline-separated list).
    - **Impact/Results**: Must pull from the `results_metrics` array within `service_data_json`.
- **Media**: Additional project images MUST be rendered from the `additional_images` JSON array, supporting both lightbox galleries and parallax dividers.

## 22. Visual Data Management (No Raw JSON Entry)
- **Mandatory Rule**: Administrative forms **MUST NOT** require the user to input or edit raw JSON strings for complex data (e.g., image lists, feature arrays).
- **Implementation Standards**:
    - **Image Lists**: Must use a visual grid uploader with thumbnails and delete triggers.
    - **Array Fields**: Must use dynamic "Add Row" UI components.
    - **Backend Sync**: All visual UI components must automatically serialize their state into a hidden JSON input for database persistence, ensuring a seamless user experience.
    - **Validation**: Every complex input must be preceded by a visual preview or summary state to prevent "guessing" what the JSON data represents.

## 23. Modular Service Layouts (Portfolio Architecture)
- **Mandatory Rule**: The `work-view.php` file MUST NOT contain hardcoded blocks for specific service layouts. It must act strictly as a controller.
- **Component Architecture**: 
    - Service-specific hero and body sections MUST be housed in the `include/work_services/` directory.
    - File naming conventions: `hero-{slug}.php` and `body-{slug}.php` (e.g., `hero-ui-ux.php`).
- **Implementation**:
    - Use associative arrays (`$heroMap`, `$bodyMap`) to map the `service_slug` to the correct include file.
    - Always provide a fallback to `hero-standard.php` and `body-standard.php` if the specific service file does not exist.
- **Integrity**: All included files automatically inherit the controller's variables (`$work`, `$serviceData`, etc.) and must maintain the "Systematic Design" principles (e.g., Avatar Clickable, Comparison Sliders, Parallax).

## 24. Input Limits & Data Constraints
- **Functionality Grids**: High-Performance features in the portfolio must be limited to exactly **4 items** to maintain layout consistency.
- **Case Study Gallery**: Additional project images/videos are limited to **4 assets** total.
- **Administrative Feedback**: When a limit is reached, use `showPremiumAlert` with the `'info'` theme (Information badge) rather than the standard warning theme.
- **Implementation**: Limits must be enforced both on the "Add Row" trigger and during the "Multiple Upload" asset intake.

### 25. Storage & Asset Lifecycle
- **Capacity**: Portfolio storage is capped at **5000MB (5GB)** for high-fidelity work assets.
- **Auto-Cleanup**: Upon deletion of any "Work" asset, the system MUST permanently remove all associated media (images, videos, logos) from the filesystem to preserve storage space.
- **Naming Protocol**: Uploaded files MUST be prefixed with the sanitized project title and a unique timestamp to prevent collisions and ensure administrative traceability.
- **File Types**: Supported high-fidelity assets include `.webp`, `.mp4`, `.webm`, and `.svg` for optimal performance.
