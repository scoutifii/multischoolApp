<IfModule mod_rewrite.c>
# For security reasons, Option followsymlinks cannot be overridden.
#Options +FollowSymLinks

Options +SymLinksIfOwnerMatch
RewriteEngine on

# NOTICE: If you get a 404 play with combinations of the following commented out lines
#AllowOverride All
#RewriteBase /crm/
# Keep people out of codeigniter directory and Git/Mercurial data

RedirectMatch 403 ^/(application\/cache|codeigniter|\.git|\.hg).*$

# Send request via index.php (again, not if its a real file or folder)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
<IfModule mod_php5.c>
RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
<IfModule !mod_php5.c>
RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>
</IfModule>
