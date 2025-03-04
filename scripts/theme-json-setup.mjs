import fs from 'fs';
import path from 'path';

function generateCSSVariablesComment(themeJson) {
    const variables = [];

    // Add color variables
    themeJson.settings.color.palette.forEach(color => {
        variables.push(`--wp--preset--color--${color.slug}: ${color.color};`);
    });

    // Add font family variables
    themeJson.settings.typography.fontFamilies.forEach(font => {
        variables.push(`--wp--preset--font-family--${font.slug}: ${font.fontFamily};`);
    });

    // Add custom variables
    Object.entries(themeJson.settings.custom).forEach(([key, value]) => {
        variables.push(`--wp--custom--${key}: ${value};`);
    });

    return `/*
Available CSS Variables:
${variables.map(v => v).join('\n')}

Usage examples:
.my-element {
    color: var(--wp--preset--color--primary);
    font-family: var(--wp--preset--font-family--primary);
    padding-top: var(--wp--custom--section-padding-y);
}
*/\n\n`;
}

function generateCSSVariablesDoc(themeJson) {
    const variables = [];

    // Add color variables
    themeJson.settings.color.palette.forEach(color => {
        variables.push(`--wp--preset--color--${color.slug}: ${color.color};`);
    });

    // Add font family variables
    themeJson.settings.typography.fontFamilies.forEach(font => {
        variables.push(`--wp--preset--font-family--${font.slug}: ${font.fontFamily};`);
    });

    // Add custom variables
    Object.entries(themeJson.settings.custom).forEach(([key, value]) => {
        variables.push(`--wp--custom--${key}: ${value};`);
    });

    return `/**
 * WordPress Theme Variables
 * Auto-generated from theme.json
 */

/**
 * Available CSS Variables:
 * ${variables.map(v => ' * ' + v).join('\n')}
 */

/**
 * Usage examples:
 * 
 * .my-element {
 *     color: var(--wp--preset--color--primary);
 *     font-family: var(--wp--preset--font-family--primary);
 *     padding-top: var(--wp--custom--section-padding-y);
 * }
 */`;
}

function convertTokensToThemeJson() {
    try {
        const tokensPath = path.join(process.cwd(), 'tokens.json');
        const themeJsonPath = path.join(process.cwd(), 'theme.json');

        if (!fs.existsSync(tokensPath)) {
            console.error('❌ tokens.json not found!');
            return;
        }

        // Read and clean the raw content
        let rawTokens = fs.readFileSync(tokensPath, 'utf8')
            .trim()
            .replace(/%$/, '');

        // Parse the JSON string
        let tokens;
        try {
            tokens = JSON.parse(JSON.parse(rawTokens));
            console.log('✓ Parsed tokens successfully:', tokens);
        } catch (e) {
            console.error('Failed to parse tokens.json:', e.message);
            return;
        }

        // Initialize default theme.json structure
        let themeJson = {
            version: 1,
            settings: {
                color: {
                    background: false,
                    link: true,
                    text: true,
                    palette: []
                },
                typography: {
                    fontSizes: [],
                    fontFamilies: []
                },
                custom: {} // For other custom variables
            }
        };

        // Try to load existing theme.json if it exists
        try {
            if (fs.existsSync(themeJsonPath)) {
                const existingContent = fs.readFileSync(themeJsonPath, 'utf8');
                if (existingContent.trim()) {
                    themeJson = JSON.parse(existingContent);
                    if (!themeJson.settings.custom) themeJson.settings.custom = {};
                    console.log('✓ Loaded existing theme.json');
                }
            }
        } catch (e) {
            console.log('Creating new theme.json file');
        }

        // Process tokens from the new structure
        if (tokens['collection-1']?.['mode-1']) {
            const tokenData = tokens['collection-1']['mode-1'];

            // Process each token
            Object.entries(tokenData).forEach(([key, value]) => {
                if (key.startsWith('color-')) {
                    // Handle colors
                    const colorName = key.replace('color-', '');
                    const existingColorIndex = themeJson.settings.color.palette.findIndex(c => c.slug === colorName);
                    
                    const colorEntry = {
                        slug: colorName,
                        color: value,
                        name: colorName.charAt(0).toUpperCase() + colorName.slice(1)
                    };

                    if (existingColorIndex === -1) {
                        themeJson.settings.color.palette.push(colorEntry);
                    } else {
                        themeJson.settings.color.palette[existingColorIndex] = colorEntry;
                    }
                } else if (key.startsWith('font-')) {
                    // Handle fonts
                    const fontName = key.replace('font-', '');
                    const existingFontIndex = themeJson.settings.typography.fontFamilies.findIndex(f => f.slug === fontName);
                    
                    const fontEntry = {
                        slug: fontName,
                        fontFamily: value,
                        name: fontName.charAt(0).toUpperCase() + fontName.slice(1)
                    };

                    if (existingFontIndex === -1) {
                        themeJson.settings.typography.fontFamilies.push(fontEntry);
                    } else {
                        themeJson.settings.typography.fontFamilies[existingFontIndex] = fontEntry;
                    }
                } else {
                    // Handle other custom variables
                    themeJson.settings.custom[key] = value;
                }
            });
        }

        // Write theme.json without comments (just the JSON)
        fs.writeFileSync(themeJsonPath, JSON.stringify(themeJson, null, 2));
        
        // Write CSS documentation file
        const cssDocPath = path.join(process.cwd(), 'assets', 'css', 'theme-variables.css');
        
        // Create directories if they don't exist
        const cssDir = path.dirname(cssDocPath);
        if (!fs.existsSync(cssDir)) {
            fs.mkdirSync(cssDir, { recursive: true });
        }
        
        fs.writeFileSync(cssDocPath, generateCSSVariablesDoc(themeJson));
        
        console.log('✅ theme.json has been updated successfully!');
        console.log('✅ theme-variables.css documentation has been created!');

    } catch (error) {
        console.error('❌ Error:', error.message);
        console.error('Stack:', error.stack);
    }
}

convertTokensToThemeJson();