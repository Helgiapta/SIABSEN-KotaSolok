tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "primary": "#0F4C75",
                "primary-light": "#3282B8",
                "primary-dark": "#1B262C",
                "primary-100": "#BBE1FA",
                "background-light": "#f6f6f8",
                "background-dark": "#121A1E",
                "surface-light": "#ffffff",
                "surface-dark": "#1B262C",
            },
            fontFamily: {
                "display": ["Inter", "sans-serif"],
                "sans": ["Inter", "sans-serif"]
            },
            borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
        },
    },
}
