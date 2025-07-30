export default (Alpine) => {

    const defaultTheme = localStorage.getItem('theme') || 'system';

    const getSystemThemePreference = () => {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    
    function isDarkMode(mode) {
        return mode === 'dark' || (mode === 'system' && getSystemThemePreference() === 'dark');
    }

    function toggleColorScheme(isDarkMode) {
        if (isDarkMode) {
            document.documentElement.setAttribute('data-theme', 'dark');
            document.documentElement.setAttribute('color-theme', 'dark');
            document.documentElement.style.setProperty('color-scheme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            document.documentElement.setAttribute('color-theme', 'light');
            document.documentElement.style.setProperty('color-scheme', 'light');
        }
        document.documentElement.classList.toggle(
            "dark",
            isDarkMode
        );
    }

    Alpine.store('theme', {
        mode: defaultTheme,
        setTheme(mode) {
            if (mode == 'system' || mode == 'dark' || mode == 'light') {
                this.mode = mode;
                localStorage.setItem('theme', mode);
            }
        },
        isDarkMode() {
            return isDarkMode(this.mode);
        },
        matchMode(mode) {
            return this.mode === mode;
        },
        isSystemMode() {
            return this.matchMode('system');
        },
        toggleTheme() {
            if (this.isDarkMode()) {
                this.setTheme('light');
            } else {
                this.setTheme('dark');
            }
        }
    });

    Alpine.effect(() => {
        toggleColorScheme(Alpine.store('theme').isDarkMode());
    })

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
        // If the user changes their system theme, update the Alpine store
        Alpine.store('theme').setTheme(event.matches ? "dark" : "light")
    });
}