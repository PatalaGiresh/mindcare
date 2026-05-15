// MindCare — All UI behaviour has been moved to CSS and PHP/Blade.
// This file is intentionally minimal. No JavaScript is required.
//
// Functionality replaced:
//   • Alert auto-dismiss     → CSS @keyframes alertAutoDismiss (mindcare.css)
//   • Card entrance anims    → CSS @keyframes cardEntrance with nth-child delays (mindcare.css)
//   • Tag chip toggle        → CSS :has(input:checked) checkbox trick (mindcare.css)
//   • Smooth scroll          → html { scroll-behavior: smooth } (mindcare.css)
//   • Confirm dialogs        → inline onsubmit="return confirm(...)" on <form> elements (Blade)
//   • Locale select submit   → native onchange="this.form.submit()" (Blade)
