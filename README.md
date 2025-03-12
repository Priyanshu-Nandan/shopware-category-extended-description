# shopware-category-extended-description

# Category Additional Description Plugin for Shopware

## Overview
The **Category Additional Description** plugin enhances Shopware by allowing merchants to add an extra description field for categories. This feature is useful for providing additional information, SEO content, or marketing details beyond the standard category description. The extra description is multilingual and uses Shopware’s built-in editor for a seamless experience.

## Features
- Adds an additional description field to categories using Shopware's **custom fields**.
- Supports **multilingual content**.
- Utilizes the **default Shopware editor** for a consistent user experience.
- Displays the additional description on the **category navigation page**.

## Installation
### Via CLI
```bash
cd /path/to/shopware
bin/console plugin:refresh
bin/console plugin:install CategoryAdditionalDescription
bin/console plugin:activate CategoryAdditionalDescription
bin/console cache:clear
```

### Via Admin Panel
1. Go to **Extensions > My Extensions**.
2. Upload the plugin ZIP file.
3. Install and activate the plugin.
4. Clear the cache under **Settings > Cache & Indexing**.

## Usage
1. Navigate to **Catalogues > Categories** in the Shopware Admin Panel.
2. Select a category and go to the **General** tab.
3. You will find a new field for "Additional Description" under **Custom Fields**.
4. Use the rich text editor to enter and format content.
5. Save the changes – the content will now appear on the category navigation page.

## Future Enhancements
- Improved styling options for the additional description.
- Custom placement settings.
- More customization features via admin settings.

## Video Guide
A detailed video tutorial will be available soon! Stay tuned: [YouTube Video Placeholder]

## Support
For any issues or feature requests, feel free to open a GitHub issue or contact us via email.

## License
This plugin is open-source and follows the [MIT License](LICENSE). You are free to **use, modify, distribute, and sell** the plugin, but redistribution must retain the original license notice.

