---
trigger: always_on
---

# Weburea AI Agent: Project Synchronization Directives

**STATUS: ACTIVE SYNCHRONIZATION**
**SOURCE OF TRUTH: rules/rules.md**

## 🎯 Executive Mandate

This agent is strictly bound to the **Weburea Project Standards** located in the `rules/` directory. You MUST NOT deviate from the established patterns for UI/UX, security, or architecture defined in that folder.

## 🔗 Master Rule Index (rules/rules.md)

The following 17 sections in the master rules file are the governing principles for all your actions:

1. **UI/UX & Feedback**: Mandatory use of `showToast` and `inject_toast_system`.
2. **Premium Modals**: Use of `showPremiumAlert` and `showPremiumDeleteModal` with specific themes.
3. **Custom Selects**: Deprecation of standard selects in favor of `renderPremiumSelect`.
4. **Architecture**: All backend logic restricted to `/api`.
5. **API Standards**: Mandatory session validation and `X-API-Key` checks.
6. **Non-Destructive Ops**: Absolute ban on permanent deletes; use soft-deletes and mock testing modes.
7. **Database Integrity**: All schema changes must originate from `/sql` scripts.
8. **File Naming**: PHP-first architecture; modular includes in `/include`.
9. **Color Tokens**: Strict use of Midnight Blue gradients and Weburea Orange.
10. **Dashboard Design**: Use of `assets/css/dashboard.css` and specific storage widget sync logic.
11. **Table Systems**: Mandatory use of `.table-premium` and responsive wrappers.
12. **Z-Index Management**: Auto-boosting Z-index for active premium selectors.
13. **Social Selectors**: Pre-defined platform maps for social icon consistency.
14. **Media Uploads**: Use of `.avatar-clickable` with camera overlays and scaling animations.
15. **Workflow**: No online demos (Scatterpad). Direct-to-confirmation deployment.
16. **Global Sync**: Shared components (Reviews/CTA) must query the `homepage_sections` table.
17. **Structural Integrity**: Strict synchronization of dual-sliders (Swiper Controller) and container spacing (`max-width-1550`).

## 🛠️ Implementation Protocol

- **Discovery**: Before editing any file, verify if a rule exists in `rules/rules.md` for that component.
- **Validation**: Compare your proposed change against the `index-application-showcase.html` reference template.
- **Consistency**: If a rule is missing, infer the pattern from existing premium components (e.g., Modals, Selects).

**REASONING FOR THIS LINKAGE:**
By referencing the `rules/` folder instead of duplicating everything here, we avoid character limit errors and ensure the agent always has access to the most up-to-date, high-fidelity standards.
