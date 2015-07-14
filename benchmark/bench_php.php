<?php  if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
if (!osc_is_admin_user_logged_in()) {
    die;
}
ini_set('max_execution_time', 100);
ini_set('xdebug.max_nesting_level', 200000);
require 'BenchmarkPhp.php';


$Info = osc_plugin_get_info('benchmark/index.php');


require 'BenchmarkSec.php';    
// Complete security check
$security = tpcmem_check_security();


?>
<style>
    
 .widefat * {
    word-wrap: break-word;
}
.widefat th {
    font-weight: 400;
}
.widefat td, .widefat th {
    color: #555;
}
.widefat th {
    font-size: 14px;
    line-height: 1.3em;
    text-align: left;
}
.widefat td, .widefat th {
    padding: 8px 10px;
}

code, kbd {
    background: rgba(0, 0, 0, 0.07) none repeat scroll 0 0;
    font-size: 13px;
    margin: 0 1px;
    padding: 3px 5px 2px;
    display :inline;
}
.code, code {
    direction: ltr;
    font-family: Consolas,Monaco,monospace;
    unicode-bidi: embed;
}   
    
    
    /* Overview */
#tpcmem-overview-tabs .fixed .column-directive {
	width: 15%;
}

#tpcmem-overview-tabs table a {
	text-decoration: underline;
	color: #21759B;
}

#tpcmem-overview-tabs table a:hover {
	text-decoration: none;
}

#tpcmem-overview-tabs table th,
#tpcmem-overview-tabs table td {
	text-align: left;
	vertical-align: top;
}

#tpcmem-overview-tabs table thead th {
	font-size: 0.9em;
}

#tpcmem-overview-tabs table tbody th,
#tpcmem-overview-tabs table tbody td {
	font-size: 0.8em;
}
/* Messages */
.msgSuccess:before, .msgWarning:before, .msgError:before {
	font-weight: bold;
}

.msgSuccess:before {
	color: green;
	content: 'PASSED!';
}

.msgWarning:before {
	color: #CCCC00;
	content: 'WARNING!';
}

.msgError:before {
	color: #CC0000;
	content: 'PROBLEM FOUND!';
}

    </style>

   <?php require 'navigation.php';      ?>
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="clear"></div>
<div id="tpcmem-overview-tabs">
   <div id="tpcmem-security">
	<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="column-directive">Security Check</th>
			<th>Recommendation</th>
		</tr>
	</thead>
	<tfoot><tr><th colspan="2">&nbsp;</th></tr></tfoot>
	<tbody>
		<tr>
			<th>allow_url_fopen</th>
			<td>
				<?php if ($security['allow_url_fopen']): ?>
				<div class="msgWarning">
				<p>The <strong>allow_url_fopen</strong> directive is set to ON.  It is recommended that you disable
				allow_url_fopen in the <em>php.ini</em> file for security reasons.  This allows PHP file functions, such as 
				<code>include</code>, <code>require</code>, and <code>file_get_contents()</code>, to retrieve data from remote 
				locations (Example: FTP, web site).  According to PHP Security Consortium, a large number of code injection 
				vulnerabilities are caused by the combination of enabling allow_url_fopen, and bad input filtering.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>allow_url_fopen</strong> directive is set to OFF.  This disallows PHP file functions, such as 
				<code>include</code>, <code>require</code>, and <code>file_get_contents()</code>, from retrieving data from remote 
				locations (Example: FTP, web site).  According to PHP Security Consortium, a large number of code injection 
				vulnerabilities are caused by the combination of enabling allow_url_fopen, and bad input filtering.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>allow_url_include</th>
			<td>
				<?php if ($security['allow_url_include']): ?>
				<div class="msgError">
				<p>The <strong>allow_url_include</strong> directive is set to ON.  <code>allow_url_include</code> allows 
				remote file access via <code>include</code> and <code>require</code>.  We <em>strongly</em> recommend 
				disabling this functionality, as <code>include</code> and <code>require</code> are the most common attack 
				points for code injection attempts.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>allow_url_include</strong> directive is set to OFF.  This disables remote file access 
				via <code>include</code> and <code>require</code>.  <code>include</code> and <code>require</code> are the 
				most common attack points for code injection attempts.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>display_errors</th>
			<td>
				<?php if ($security['display_errors'] == '1'): ?>
				<div class="msgError">
				<p>The <strong>display_errors</strong> setting in <em>php.ini</em> is set to ON.  This means that PHP errors, and 
				warnings are being displayed. Such warnings can cause sensitive information to be revealed to users (paths, database 
				queries, etc.).</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>display_errors</strong> setting in <em>php.ini</em> is set to OFF.  This is the proper setting for a 
				production environment.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>magic_quotes_gpc</th>
			<td>
				<?php if ($security['magic_quotes_gpc']): ?>
				<div class="msgWarning">
				<p><strong>Magic Quotes</strong> is set to ON. This feature has been depreciated as of PHP 5.3 and removed as of PHP 
				6.0. Relying on this feature is highly discouraged. It is preferred to code with magic quotes off and to instead 
				escape the data at runtime, as needed.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p><strong>Magic Quotes</strong> is set to OFF. This is the proper setting for any environment.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>ModSecurity</th>
			<td>
				<?php if (!$security['mod_security']): ?>
				<div class="msgWarning">
				<p><strong>mod_security</strong> for Apache is not installed. ModSecurity can help protect your server against SQL 
				injections, XSS attacks, and a variety of other attacks. The Apache module is available for free at 
				<a href="http://www.modsecurity.org" title="ModSecurity">http://www.modsecurity.org</a>.</p>
				</div>
				<?php elseif ('N/A' === $security['mod_security']): ?>
				<div class="msgWarning">
				<p>Unable to determine if <strong>mod_security</strong> for Apache is installed. This can happen if a host uses 
				a different name for the Apache module, or if the <em>apache_get_modules()</em> function is not available in your 
				PHP installation. ModSecurity can help protect your server against SQL injections, XSS attacks, and a variety of 
				other attacks. The Apache module is available for free at 
				<a href="http://www.modsecurity.org" title="ModSecurity">http://www.modsecurity.org</a>.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p><strong>mod_security</strong> for Apache is installed and actively protecting your web server.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>open_basedir</th>
			<td>
				<?php if (!$security['open_basedir']): ?>
				<div class="msgWarning">
				<p>The <strong>open_basedir</strong> directive is not set. <code>open_basedir</code>, set in <em>php.ini</em>, 
				limits the PHP process from accessing files outside of the specified directories.  It is strongly 
				suggested that you set <code>open_basedir</code> to your web site documents and shared libraries 
				<em>only</em>.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>open_basedir</strong> directive is set to <code><?php echo @ini_get('open_basedir'); ?></code>. 
				<code>open_basedir</code>, set in <em>php.ini</em> limits the PHP process from accessing files outside of 
				the specified directories.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>register_globals</th>
			<td>
				<?php if ($security['register_globals']): ?>
				<div class="msgError">
				<p>The <strong>register_globals</strong> setting in <em>php.ini</em> is set to ON.  This feature has been depreciated 
				as of PHP 5.3 and removed as of PHP 6.0.  Relying on this feature is <em>highly</em> discouraged.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>register_globals</strong> setting in <em>php.ini</em> is set to OFF.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>safe_mode</th>
			<td>
				<?php if ($security['safe_mode']): ?>
				<div class="msgWarning">
				<p>The <strong>safe_mode</strong> setting in <em>php.ini</em> is set to ON.  This feature is depreciated in PHP 5.3 
				and is removed in PHP 6.0.  Relying on this feature is architecturally incorrect, as this should not be solved at 
				the PHP level.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>safe_mode</strong> setting in <em>php.ini</em> is set to OFF.  While relying on this feature is 
				architecturally incorrect because this should not be solved at the PHP level, many ISP's still use safe mode in 
				shared hosting situations due to limitations at the level the web server and OS.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>ServerSignature</th>
			<td>
				<?php if ($security['server_signature']): ?>
				<div class="msgWarning">
				<p>Apache's <strong>ServerSignature</strong> directive is set to ON. This means that your server software version, and 
				other important details are public, which can give hackers information necessary to exploit version and software-specific 
				vulnerabilities.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>Apache's <strong>ServerSignature</strong> directive is set to OFF. This prevents hackers from gaining information 
				that could help them exploit vulnerabilities based on your specific server software version.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>WP Unique Keys</th>
			<td>
				<?php if (tpcmem_check_unique_keys()): ?>
				<div class="msgSuccess">
				<p>The WordPress <strong>secret keys</strong> located in <em>wp-config.php</em> are defined.  These help add an extra 
				level of protection against hackers.  The secret keys can be changed at any time to invalidate all existing cookies, 
				which will also require users to login again.</p>
				</div>
				<?php else: ?>
				<div class="msgError">
				<p>Some of all of the WordPress <strong>secret keys</strong> located in <em>wp-config.php</em> are not defined.  WP's secret keys make your site harder to hack and access 
				by adding random elements to the password.  These keys don't have to be committed to memory, they just have to be long 
				and complicated.  The easiest way to obtain a set of secret keys is to use the 
				<a href="https://api.wordpress.org/secret-key/1.1/" title="WP Online Generator" rel="external">online generator</a>. 
				The secret keys can be changed at any time to invalidate all existing cookies, which will also require users to login again.</p>
				</div>
				<?php endif; ?>
			</td>		
		</tr>
	</tbody>
	</table>
	</div>
</div>
 
    <?php
   
$ini = BenchmarkPhp::run();
    
debug_var($ini,'Some INI variables');
//phpinfo();
 require 'info/info_php.php'
    ?>
   

    





<?php require 'benchfooter.php';      ?>