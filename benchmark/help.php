<?php
if (!osc_is_admin_user_logged_in()) {
    die;
}


require 'navigation.php';
?>

<div class="leftContent">
    <div class="wrap">




        <div class="clear"></div>
        <h1 style="margin-top: 50px;">How Benchmarks are Calculated</h1>
        <div class="benchPara">
            <pre>
Be pacient . test may take a while .....
            </pre>
            <h2>CPU Benchmark</h2>
            <pre>
We calculate CPU speed by doing two operations and taking the total time to complete both.
This calculates both the raw math performance of your server as it executes PHP code and the ability to work with strings in memory. In other words, you get a good indication of how fast the CPU is and how fast the memory channel is.
The result is presented as Loops, which is a play on the Linux "BogoMips". 
It uses an arbitrary number of assumed operations over time to give you a number you can compare with other Osclass websites and hosting platforms.

            </pre>
            <h2>Network Speed Benchmark</h2>
            <pre>
       
Plugin  will send three queries to get jquery from ajax.googleapis.com which is Google's geographically distributed content distribution network.
This gives us a good indication of what your network throughput is like no matter where your server is based in the world because Google's CDN
has a server close to most major centers.
Any decent host should have their servers close to a major center and should give you decent throughput. 

            </pre>
            <h2>Database Queries per Second</h2>
            <pre>
To benchmark your database we use the  plugin table which uses the text column .
Plugin will  do 100 inserts of 30 paragraphs of text, then 100 selects, 100 updates and 100 deletes. 
We use the time taken to calculate queries per second on each method (insert,select,update,delete).
This is a good indication of how fast your overall DB performance is in a worst case scenario when nothing is cached.

            </pre>
            <h2>Insert Item </h2>
            <pre>
A new dummy item is created (no foto) upload . After thest will be deleted. 
            </pre>
<h2>Create files </h2>
            <pre>
1000 php files are created into test _time folder .(All 1000 files will be deleted after test .)
            </pre>

            </div>

    </div>


</div>


<div class ="clear"></div>
<pre>
	  If Your HOST does not complete the TEST  means  that is too SLOW. 
</pre>
<?php
require'benchfooter.php';
?>
