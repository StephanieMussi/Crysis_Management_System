<html>
	<body  onload="startTime()">
		<!----------Top Navigation Bar-------->
		<section id = "nav-bar">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<a class="navbar-brand" href="pmo_main.php">Unknown Crysis</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!--------Logout---------->
					<div class="navbar-nav ml-auto">
						<a class="nav-item nav-link" href="..\script\logout.php">Logout</a>
					</div><div id="txt" style="color:white"></div>
				</div>
			</nav>
		</section>
	</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../script/notification/push.js"></script>
<script>
    function getIncidentNotification($notificationId){
        url = "view_incident_notification.php?view=true&notificationId="+$notificationId;
        window.location.assign(url);
    }

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);

        //check for notification
        if(s%6==0) {
            notify();
        }

        s = checkTime(s);
        document.getElementById('txt').innerHTML =
            h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 1000);
    }
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }


    function notify(){

        var arr;
        var att = "";
        var id = "";
        $.ajax({

            url : 'pmo_check_notif.php',
            type : 'POST',
            dataType: "html",
            async: false,
            cache: false,
            success : function (result) {
                console.log (result); // Here, you need to use response by PHP file.
                if(result != "NIL") {
                    arr = JSON.parse(result);
                    att = arr[0]["emergencyType"];
                    id = arr[0]["incidentId"];
                }
            },
            error : function () {
                console.log ('error');
            }

        });

        if(att!="") {
            Push.create("New Request from CMO", {
                body: att,
                icon: '../script/notification/sgsecure.png',
                timeout: 10000,
                onClick: function () {
                    window.open("http://10.27.248.222:8080/htdocs/cms/pmo/pmo_view_more_info.php?viewMore=true&incidentId=" + id,'_self');
                    this.close();
                }
            });
        }

        //ajax call to update notify status


    }

</script>