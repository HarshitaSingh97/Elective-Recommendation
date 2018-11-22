
function dashboard()
{
  //alert("dfgdg");
  //var cluster = require('k-means');
  othis=this;
  this.pool1="";
  this.pool2="";

  this.spec11=null;

  this.spec12=null;

  this.spec13=null;

  this.spec21=null;

  this.spec22=null;

  this.spec23=null;
  this.divpool1=null;
  this.divpool2=null;
  this.usn=null;
  this.branch=null;

  this.xhr= new XMLHttpRequest();
	this.load = function()
	{
		//If we came here, it means user typed something, so we hang on and not go to the server, if the user has paused,
		//then go to server(after 1 second)
    //alert("yooo");

		othis.spec11=document.getElementById("spec11");
    othis.spec12=document.getElementById("spec12");
    othis.spec13=document.getElementById("spec13");
    othis.spec21=document.getElementById("spec21");
    othis.spec22=document.getElementById("spec22");
    othis.spec23=document.getElementById("spec23");
    othis.usn=document.getElementById("usn").textContent;
    othis.branch=document.getElementById("branch").textContent;
    if(othis.branch=="CSE")
    {
      othis.branch="1";
    }
    if(othis.branch=="ECE")
    {
      othis.branch="2";
    }
    if(othis.branch=="EME")
    {
      othis.branch="3";
    }
    if(othis.branch=="EEE")
    {
      othis.branch="4";
    }
    if(othis.branch=="BT")
    {
      othis.branch="5";
    }
		if(othis.spec11.checked==true){
			othis.pool1=othis.pool1+othis.branch+"1,";
			//alert("t");
		}
    if(othis.spec12.checked==true){
      othis.pool1=othis.pool1+othis.branch+"2,";
      //alert("t");
    }
    if(othis.spec13.checked==true){
			othis.pool1=othis.pool1+othis.branch+"3,";
			//alert("t");
		}
    if(othis.spec21.checked==true){
      othis.pool2=othis.pool2+othis.branch+"1,";
      //alert("t");
    }
    if(othis.spec22.checked==true){
      othis.pool2=othis.pool2+othis.branch+"2,";
      //alert("t");
    }
    if(othis.spec23.checked==true){
      othis.pool2=othis.pool2+othis.branch+"3,";
      //alert("t");
    }
    othis.xhr.onreadystatechange=othis.displaygroups;

		othis.xhr.open("GET","http://localhost/WT2/showelectives.php?usn=" +othis.usn+"&pool1="+othis.pool1+"&pool2="+othis.pool2,true);

		othis.xhr.send();
	}

  this.displaygroups =function()
  {
    //alert("here");
    //var response=othis.xhr.responseText;

    //alert(othis.xhr.responseText);
    if(othis.xhr.readyState==4 && othis.xhr.status==200)
		{
				var response=othis.xhr.responseText;
        //alert("final");
        //alert(response);
        var splitting=response.split("analyze");
        var showpool1=(splitting[0].split(";")[0]).split(",");
        var showpool2=(splitting[0].split(";")[1]).split(",");
        var analysis=JSON.parse(splitting[1]);
    		othis.divpool1=document.getElementById("divpool1");
        othis.divpool2=document.getElementById("divpool2");
        showpool1=Array.from(new Set(showpool1));
        showpool2=Array.from(new Set(showpool2));
        othis.divpool1.innerHTML="";
        othis.divpool2.innerHTML="";
        var i=0;
        if(showpool1.length<=1){
          othis.divpool1.innerHTML="No Electives Available";
          othis.divpool1.style.color="gray";
          othis.divpool1.style.fontSize="0.8em";
        }
        else {
          for(i=0;i<showpool1.length-1;i++)
          {
            var p=document.createElement("p");
            p.textContent=showpool1[i];
            othis.divpool1.appendChild(p);
          }
        }
        if(showpool2.length<=1){
          othis.divpool2.innerHTML="No Electives Available";
          othis.divpool2.style.color="gray";
          othis.divpool2.style.fontSize="0.8em";
        }
        else {
          for(i=0;i<showpool2.length-1;i++)
          {
            var p=document.createElement("p");
            p.textContent=showpool2[i];
            othis.divpool2.appendChild(p);
          }
        }

        var chart = new CanvasJS.Chart("chartContainer",
        {
          title:{
            text: "Performance Across Semesters",
          },
          axisY: {
            title: "SGPA"
          },
          axisX: {
            title: "Semester"
          },
          legend: {
            verticalAlign: "bottom",
            horizontalAlign: "center"
          },
          theme: "theme2",
          data: [

          {
            type: "line",
            dataPoints: analysis
          },
          ]
        });

        chart.render();
        //alert(othis.xhr.responseText);
        //document.appendChild(othis.divpool1);

        othis.xhr.onreadystatechange=othis.displayclusters;

    		othis.xhr.open("GET","http://localhost/WT2/fetchclusters.php?sem=" +document.getElementById("sem").textContent,true);

    		othis.xhr.send();

    }
  }

  this.displayclusters =function()
  {
    //alert(othis.xhr.responseText);
    if(othis.xhr.readyState==4 && othis.xhr.status==200)
    {
      var response=othis.xhr.responseText;
      //alert(response);
      var splitting=response.split("separator");
      var el1=splitting[0].split(",");
      var el2=splitting[1].split(",");
      var clusterdiv=document.getElementById("clusterid");
      var i=0;
      var p=document.createElement("p");
      p.textContent="Here's what's most popular among students who share similar interests as you:";
      var p1=document.createElement("span");
      p1.textContent="pool1:";
      for (i=0;i<el1.length;i++){
        var subj=document.createElement("p")
        subj.textContent=el1[i];
        p1.appendChild(subj);
      }
      var p2=document.createElement("span");
      p2.textContent="pool2:";
      for (i=0;i<el2.length;i++){
        var subj=document.createElement("p")
        subj.textContent=el2[i];
        p2.appendChild(subj);
      }
      /*do stuff*/
      clusterdiv.appendChild(p);
      clusterdiv.appendChild(p1);
      clusterdiv.appendChild(p2);
    }
  }

  this.displaygroups1 =function()
  {
    //alert(othis.xhr.responseText);
    if(othis.xhr.readyState==4 && othis.xhr.status==200)
    {
        //alert("1");
        var response=othis.xhr.responseText;
        //alert("final");
        //alert(response);
        var splitting=response.split("analyze");
        var showpool1=(splitting[0].split(";")[0]).split(",");
        var showpool2=(splitting[0].split(";")[1]).split(",");
        var analysis=JSON.parse(splitting[1]);
        othis.divpool1=document.getElementById("divpool1");
        othis.divpool2=document.getElementById("divpool2");
        showpool1=Array.from(new Set(showpool1));
        showpool2=Array.from(new Set(showpool2));
        othis.divpool1.innerHTML="";
        //othis.divpool2.innerHTML="";
        var i=0;
        //alert(showpool1.length);
        if(showpool1.length<=1){
          othis.divpool1.innerHTML="No Electives Available";
          othis.divpool1.style.color="gray";
          othis.divpool1.style.fontSize="0.8em";
        }
        else {
          for(i=0;i<showpool1.length-1;i++)
          {
            var p=document.createElement("p");
            p.textContent=showpool1[i];
            othis.divpool1.appendChild(p);
          }
        }
        /*for(i=0;i<showpool2.length-1;i++)
        {
          var p=document.createElement("p");
          p.textContent=showpool2[i];
          othis.divpool2.appendChild(p);
        }*/
        //alert(othis.xhr.responseText);
        //document.appendChild(othis.divpool1);

    }
  }



  this.displaygroups2 =function()
  {
    //alert(othis.xhr.responseText);
    if(othis.xhr.readyState==4 && othis.xhr.status==200)
    {
        //alert("2");
        var response=othis.xhr.responseText;
        //alert("final");
        //alert(response);
        var splitting=response.split("analyze");
        var showpool1=(splitting[0].split(";")[0]).split(",");
        var showpool2=(splitting[0].split(";")[1]).split(",");
        var analysis=JSON.parse(splitting[1]);
        othis.divpool1=document.getElementById("divpool1");
        othis.divpool2=document.getElementById("divpool2");
        showpool1=Array.from(new Set(showpool1));
        showpool2=Array.from(new Set(showpool2));
        //othis.divpool1.innerHTML="";
        othis.divpool2.innerHTML="";
        var i=0;
        /*for(i=0;i<showpool1.length-1;i++)
        {
          var p=document.createElement("p");
          p.textContent=showpool1[i];
          othis.divpool1.appendChild(p);
        }*/
        if(showpool2.length<=1){
          othis.divpool2.innerHTML="No Electives Available";
          othis.divpool2.style.color="gray";
          othis.divpool2.style.fontSize="0.8em";
        }
        else {
          for(i=0;i<showpool2.length-1;i++)
          {
            var p=document.createElement("p");
            p.textContent=showpool2[i];
            othis.divpool2.appendChild(p);
          }
        }


        //alert(othis.xhr.responseText);
        //document.appendChild(othis.divpool1);

    }
  }




  this.filterpool1 = function()
  {
    othis.pool1="";
    othis.pool2="";
    //alert("here");
    othis.spec11=document.getElementById("spec11");
    othis.spec12=document.getElementById("spec12");
    othis.spec13=document.getElementById("spec13");
    othis.spec21=document.getElementById("spec21");
    othis.spec22=document.getElementById("spec22");
    othis.spec23=document.getElementById("spec23");
    othis.usn=document.getElementById("usn").textContent;
    othis.branch=document.getElementById("branch").textContent;
    if(othis.branch=="CSE")
    {
      othis.branch="1";
    }
    if(othis.branch=="ECE")
    {
      othis.branch="2";
    }
    if(othis.branch=="EME")
    {
      othis.branch="3";
    }
    if(othis.branch=="EEE")
    {
      othis.branch="4";
    }
    if(othis.branch=="BT")
    {
      othis.branch="5";
    }
		if(othis.spec11.checked==true){
			othis.pool1=othis.pool1+othis.branch+"1,";
			//alert("t");
		}
    if(othis.spec12.checked==true){
      othis.pool1=othis.pool1+othis.branch+"2,";
      //alert("t");
    }
    if(othis.spec13.checked==true){
			othis.pool1=othis.pool1+othis.branch+"3,";
			//alert("t");
		}
    if(othis.spec21.checked==true){
      othis.pool2=othis.pool2+othis.branch+"1,";
      //alert("t");
    }
    if(othis.spec22.checked==true){
      othis.pool2=othis.pool2+othis.branch+"2,";
      //alert("t");
    }
    if(othis.spec23.checked==true){
      othis.pool2=othis.pool2+othis.branch+"3,";
      //alert("t");
    }
    othis.pool2="";
    othis.xhr.onreadystatechange=othis.displaygroups1;

		othis.xhr.open("GET","http://localhost/WT2/showelectives.php?usn=" +othis.usn+"&pool1="+othis.pool1+"&pool2="+othis.pool2,true);

		othis.xhr.send();
  }
  this.filterpool2 = function()
  {

      othis.pool1="";
      othis.pool2="";
      //alert("pool2");
      othis.spec11=document.getElementById("spec11");
      othis.spec12=document.getElementById("spec12");
      othis.spec13=document.getElementById("spec13");
      othis.spec21=document.getElementById("spec21");
      othis.spec22=document.getElementById("spec22");
      othis.spec23=document.getElementById("spec23");
      othis.usn=document.getElementById("usn").textContent;
      othis.branch=document.getElementById("branch").textContent;
      if(othis.branch=="CSE")
      {
        othis.branch="1";
      }
      if(othis.branch=="ECE")
      {
        othis.branch="2";
      }
      if(othis.branch=="EME")
      {
        othis.branch="3";
      }
      if(othis.branch=="EEE")
      {
        othis.branch="4";
      }
      if(othis.branch=="BT")
      {
        othis.branch="5";
      }
  		if(othis.spec11.checked==true){
  			othis.pool1=othis.pool1+othis.branch+"1,";
  			//alert("t");
  		}
      if(othis.spec12.checked==true){
        othis.pool1=othis.pool1+othis.branch+"2,";
        //alert("t");
      }
      if(othis.spec13.checked==true){
  			othis.pool1=othis.pool1+othis.branch+"3,";
  			//alert("t");
  		}
      if(othis.spec21.checked==true){
        //alert("yahh1");
        othis.pool2=othis.pool2+othis.branch+"1,";
        //alert("t");
      }
      if(othis.spec22.checked==true){
        //alert("yahh2");
        othis.pool2=othis.pool2+othis.branch+"2,";
        //alert("t");
      }
      if(othis.spec23.checked==true){
        //alert("yahh3");
        othis.pool2=othis.pool2+othis.branch+"3,";
        //alert("t");
      }
      othis.pool1="";
      othis.xhr.onreadystatechange=othis.displaygroups2;
      //alert(othis.pool2);
  		othis.xhr.open("GET","http://localhost/WT2/showelectives.php?usn=" +othis.usn+"&pool1="+othis.pool1+"&pool2="+othis.pool2,true);

  		othis.xhr.send();
  }

}

obj=new dashboard();
