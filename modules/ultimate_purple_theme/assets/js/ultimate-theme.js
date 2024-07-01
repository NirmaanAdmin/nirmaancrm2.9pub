$(document).ready(function() {
    // Color Picker Tool Js 1
    const dynamicInputs = document.querySelectorAll('input.input-color-picker');
    const handleThemeUpdate = (cssVars) => {
        const root = document.querySelector(':root');
            const keys = Object.keys(cssVars);
            keys.forEach(key => {
            root.style.setProperty(key, cssVars[key]);
        });
    }

    dynamicInputs.forEach((item) => {
        item.addEventListener('input', (e) => {
            const cssPropName = `--primary-color`;
            console.log(cssPropName)
            handleThemeUpdate({
            [cssPropName]: e.target.value
            });
        });
    });
});

$(document).ready(function() {
    // Color Picker Tool Js 2
    const dynamicInputs2 = document.querySelectorAll('input.input-color-picker2');
    const handleThemeUpdate = (cssVars) => {
        const root = document.querySelector(':root');
            const keys = Object.keys(cssVars);
            keys.forEach(key => {
            root.style.setProperty(key, cssVars[key]);
        });
    }

    dynamicInputs2.forEach((item) => {
        item.addEventListener('input', (e) => {
            const cssPropName = `--secondary-color`;
            console.log(cssPropName)
            handleThemeUpdate({
            [cssPropName]: e.target.value
            });
        });
    });
});