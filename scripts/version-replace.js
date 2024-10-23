const fs = require('fs-extra');

async function updateVersionInFiles() {
    try {
        const replace = await import('replace-in-file');
        const { replaceInFile } = replace;  // Directly using the named export

        const pluginFiles = ['includes/**/*', 'templates/*', 'src/*', 'helpers/*', 'flexibleDataTableBlock.php'];
        const data = await fs.readFile('package.json', 'utf8');
        const { version } = JSON.parse(data);

        // Replace the version in the specified files
        const results = await replaceInFile({
            files: pluginFiles,
            from: /FLEXIBLEDATATABLEBLOCK_SINCE/g,
            to: version,
        });

        console.log('Replacement results:', results);
    } catch (error) {
        console.error('Error occurred:', error);
    }
}

updateVersionInFiles();

FLEXIBLEDATATABLEBLOCK_SINCE