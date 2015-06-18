
	
	function CheckFriendRequests()
	{
		var numOfRequests, text;	
	
		xmlhttp=new XMLHttpRequest();
  		xmlhttp.onreadystatechange=function()
  		{
			//alert("RS: "+xmlhttp.readyState+ "Stat: " + xmlhttp.status);
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
				numOfRequests = xmlhttp.responseText;

                 if(numOfRequests == 1)
				{
					document.getElementById("request").innerHTML = '1 Request';
				}
				/*else if(numOfRequests == 0)
				{
					document.getElementById("request").style.height = "0px";
					document.getElementById("request").style.visibility = "hidden";
				}*/
				else
				{
					document.getElementById("request").innerHTML = numOfRequests.toString() + " Requests";
				}
	 		}
			if(xmlhttp.status == 500)
			{
				document.writeln("");
			}
  		}	

		xmlhttp.open("POST","CheckFriendRequests.php",true);
		xmlhttp.send();
		statusTmr = setTimeout("CheckFriendRequests()", 5000);
	}

statusTmr = setTimeout("CheckFriendRequests()", 1000);

