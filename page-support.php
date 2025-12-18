<?php
/**
 * Template Name: Support (Static Copy)
 * 
 * This template loads the static HTML from bitrix_original/copy/support.html
 * and outputs it exactly as-is, only adjusting asset paths.
 */

// Path to the original HTML file
// From theme: test.tex/wp-content/themes/tex-k_test/
// Go up 5 levels to reach: tex-k.com.ua/
// Then: bitrix_original/copy/support.html

// Try multiple possible paths
$possible_paths = array(
    // From theme directory: go up 5 levels
    dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/bitrix_original/copy/support.html',
    // From WordPress root (ABSPATH): go up one level
    dirname(ABSPATH) . '/bitrix_original/copy/support.html',
    // Absolute path
    '/var/www/tex_k_com_ua_usr/data/www/tex-k.com.ua/bitrix_original/copy/support.html',
);

$html_file = null;
foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        $html_file = $path;
        break;
    }
}

if (!$html_file || !file_exists($html_file)) {
    $error_msg = 'Support HTML file not found. Tried paths:' . "\n";
    foreach ($possible_paths as $path) {
        $error_msg .= '  - ' . $path . (file_exists($path) ? ' (exists)' : ' (not found)') . "\n";
    }
    wp_die($error_msg);
}

// Read the HTML content
$html_content = file_get_contents($html_file);

// Determine the base path for assets
// For test.tex site: /test.tex/bitrix_original/copy/support_files/
// But we'll use absolute path from site root: /bitrix_original/copy/support_files/
$base_path = '/bitrix_original/copy/support_files/';

// Replace all relative paths to support_files
$html_content = str_replace('./support_files/', $base_path, $html_content);
$html_content = str_replace('href="./support_files/', 'href="' . $base_path, $html_content);
$html_content = str_replace('src="./support_files/', 'src="' . $base_path, $html_content);
$html_content = str_replace('data-src="./support_files/', 'data-src="' . $base_path, $html_content);

// Also fix paths that might be in the HTML
$html_content = preg_replace('/(href|src|data-src)=["\']\.\/support_files\//i', '$1="' . $base_path, $html_content);

// Output the HTML directly, bypassing WordPress header/footer
// This ensures 1:1 match with original
echo $html_content;
exit;
