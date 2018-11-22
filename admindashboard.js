//constructor function. Will use it to create 'obj' which we will use for suggest functionality
//constructor function. Will use it to create 'obj' which we will use for suggest functionality

function Suggest()
{
	othis=this;
	othis.usn=null;
	othis.containerdiv=null;
	othis.timer=null;
	othis.studenttable=null;
	othis.electivescontainer=null;
	othis.countcontainer=null;
	this.xhr= new XMLHttpRequest();

	this.getstudents = function()
	{
		//If we came here, it means user typed something, so we hang on and not go to the server, if the user has paused,
		//then go to server(after 1 second)
		//alert("yah");
		if(othis.timer)
		{
			clearTimeout(othis.timer);
		}
		othis.timer=setTimeout(othis.fetchstudents,1000);
	};

	this.fetchstudents = function()
	{
		othis.usn = document.getElementById("usn");
		othis.containerdiv = document.getElementById("container");

		othis.containerdiv.innerHTML = "";
		if(othis.usn.value == "")
		{
			//There is nothing to do
			othis.containerdiv.innerHTML = "";
			othis.containerdiv.style.display = "none";
			return;
		}

		// Else we have two choices. One, we can check in our cache.
		// If we had previously searched for this moviepart, we will find it
		// in our cache. We load it from there. Else, we have no option
		// but to go to the server
		else
		{
			//Now we have to go to the server
			othis.xhr.onreadystatechange = othis.processResults;
			//alert(othis.usn.value);
			// Open a GET connection
			othis.xhr.open("GET", "http://localhost/WT2/getstudents.php?usn="+othis.usn.value, true);
			//alert(othis.usn.value);
			othis.xhr.send();

		}
	}
	this.processResults = function()
	{
		//alert("sdfdg");
			//response=othis.xhr.responseText;
			//alert(response);

		if(othis.xhr.readyState==4 && othis.xhr.status==200)
		{
			response=othis.xhr.responseText;
			//alert(response);

			students=response.split("newentry");
			//movies=movies.split("moviemaniamovies");


			othis.containerdiv.innerHTML="";

			if(students.length==0 || students.length==1)
			{
				//alert("here");
				othis.containerdiv.innerHTML="";
				othis.containerdiv.style.display="none";
				othis.studenttable=document.getElementById("studenttable");
				othis.studenttable.innerHTML="No results returned for your search!";
				othis.studenttable.style.color="gray";

				//also let the user know that there were no match
				//othis.movie.className="notfound";

			}

			//else we found match
			//lets add it to the containerdiv

			else
			{

				othis.studenttable=document.getElementById("studenttable");
				othis.studenttable.style.color="black";

				//alert("populating");
				othis.populate(students);
				othis.displaystudents(response);
			}
		}
	}
	this.populate = function(students)
	{

		//alert(students[0]);
			leng=students.length;
			if(students.length>5){
				leng=5;
			}
			othis.containerdiv.innerHTML="";
			for(i=0;i<leng;i++)
			{
				if(students[i].length>0)
				{
					//alert("nada");
					students[i]=(students[i].split(","))[0];
					//alert(students[0]);

					div=document.createElement("div");

					div.innerHTML=students[i];
					div.className="suggest";

					div.onclick=othis.setstudent;
					if(i==students.length-1){
						div.style.bottom="0.5px solid green";
					}
					othis.containerdiv.appendChild(div);
				}
			}
			othis.containerdiv.style.display="block";
			othis.containerdiv.style.border="1px solid black";

	}
	this.setstudent = function()
	{
		clickeddiv=event.target;
		othis.usn.value=clickeddiv.innerHTML;

		othis.containerdiv.innerHTML="";
		othis.containerdiv.style.display="none";

		othis.usn.className="found";
	}

	this.displaystudents = function(students)
	{
			othis.studenttable=document.getElementById("studenttable");
			othis.studenttable.innerHTML="";
			students=students.split("newentry");
			var table=document.createElement("table");
			table.style.width="100%";
			var row=document.createElement("tr");
			var head1=document.createElement("th");
			head1.textContent="srn";
			head1.style.width="50%";
			var head2=document.createElement("th");
			head2.textContent="branch";
			head2.style.width="50%";
			table.appendChild(head1);
			table.appendChild(head2);
			var i=0;
			for(i=0;i<students.length-1;i++)
			{
				var srn=(students[i].split(","))[0];
				var branch=(students[i].split(","))[1];
				//alert(students[i]);
				switch (branch) {
					case 1:
						branch="CSE";
					case 2:
						branch="ECE";

						break;

				}
				var row=document.createElement("tr");
				var col1=document.createElement("td");
				col1.textContent=srn;
				col1.style.width="50%";
				var col2=document.createElement("td");
				col2.textContent=branch;
				col2.style.width="50%";
				//alert(branch);
				row.appendChild(col1);
				row.appendChild(col2);
				table.appendChild(row);
			}
			othis.studenttable.appendChild(table);
	}
	this.fetchelectives = function()
	{
		othis.xhr.onreadystatechange = othis.showelectives;
		othis.xhr.open("GET", "http://localhost/WT2/searchelectives.php?branch="+document.getElementById("branchsearch").value+"&code="+document.getElementById("code").value+"&name="+document.getElementById("searchname").value, true);
		othis.xhr.send();
	}
	this.showelectives = function()
	{
		if(othis.xhr.readyState==4 && othis.xhr.status==200)
		{
			response=othis.xhr.responseText;
			electives=response.split("newentry");
			//movies=movies.split("moviemaniamovies");
			//alert(response);
			othis.electivescontainer=document.getElementById("electivescontainer");
			othis.electivescontainer.innerHTML="";

			if(electives.length==0 || electives.length==1)
			{
				//alert("here");
				othis.electivescontainer.innerHTML="No results returned for your search!";
				othis.electivescontainer.style.color="gray";
				//othis.electivescontainer.style.display="none";

				//also let the user know that there were no match
				//othis.movie.className="notfound";

			}

			//else we found match
			//lets add it to the containerdiv

			else
			{
				othis.electivescontainer.style.color="black";
				var i=0;
				var table=document.createElement("table");
				table.style.width="100%";
				var row=document.createElement("tr");
				var head1=document.createElement("th");
				head1.textContent="Elective";
				head1.style.width="25%";
				var head2=document.createElement("th");
				head2.textContent="Code";
				head2.style.width="25%";
				var head3=document.createElement("th");
				head3.textContent="Branch";
				head3.style.width="25%";
				var head4=document.createElement("th");
				head4.textContent="Semester";
				head4.style.width="25%";
				table.appendChild(head1);
				table.appendChild(head2);
				table.appendChild(head3);
				table.appendChild(head4);
				for(i=0;i<electives.length-1;i++)
				{
					var elective=electives[i].split(",");


						var name=elective[0];
						var code=elective[1];
						var branch=elective[2];
						var sem=elective[3];


						var row=document.createElement("tr");
						var col1=document.createElement("td");
						col1.textContent=name;
						col1.style.width="25%";
						var col2=document.createElement("td");
						col2.textContent=code;
						col2.style.width="25%";
						var col3=document.createElement("td");
						col3.textContent=branch;
						col3.style.width="25%";
						var col4=document.createElement("td");
						col4.textContent=sem;
						col4.style.width="25%";
						//alert(branch);
						row.appendChild(col1);
						row.appendChild(col2);
						row.appendChild(col3);
						row.appendChild(col4);
						table.appendChild(row);

					othis.electivescontainer.appendChild(table);
				}
				//alert("populating");
				//othis.populate(students);
				//othis.displaystudents(response);
			}
		}
	}

	this.clearelectives = function()
	{
		othis.electivescontainer=document.getElementById("electivescontainer");
		othis.electivescontainer.innerHTML="";
		document.getElementById("branchsearch").value="";
		document.getElementById("code").value="";
		document.getElementById("searchname").value="";
	}




	this.fetchcount = function()
	{
		othis.xhr.onreadystatechange = othis.showcount;
		othis.xhr.open("GET", "http://localhost/WT2/getcount.php?branch="+document.getElementById("branchcount").value, true);
		othis.xhr.send();
	}

	this.showcount = function()
	{
		if(othis.xhr.readyState==4 && othis.xhr.status==200)
		{
			response=othis.xhr.responseText;
			var counts=response.split("newentry");
			//movies=movies.split("moviemaniamovies");
			//alert(response);
			othis.countcontainer=document.getElementById("countcontainer");
			othis.countcontainer.innerHTML="";

			if(counts.length==0 || counts.length==1)
			{
				//alert("here");
				othis.countcontainer.innerHTML="No results returned for your search!";
				othis.countcontainer.style.color="gray";

				//also let the user know that there were no match
				//othis.movie.className="notfound";

			}

			//else we found match
			//lets add it to the containerdiv

			else
			{
				var i=0;
				othis.countcontainer.style.color="black";
				var table=document.createElement("table");
				table.style.width="100%";
				var row=document.createElement("tr");
				var head1=document.createElement("th");
				head1.textContent="Elective";
				head1.style.width="25%";

				var head2=document.createElement("th");
				head2.textContent="Code";
				head2.style.width="25%";
				var head3=document.createElement("th");
				head3.textContent="Branch";
				head3.style.width="25%";
				var head4=document.createElement("th");
				head4.textContent="Count";
				head4.style.width="25%";

				table.appendChild(head1);
				table.appendChild(head2);
				table.appendChild(head3);
				table.appendChild(head4);


				for(i=0;i<counts.length-1;i++)
				{
					var count=counts[i].split(",");


						var name=count[0];
						var code=count[1];
						var branch=count[2];
						var count=count[3];


						var row=document.createElement("tr");
						var col1=document.createElement("td");
						col1.textContent=name;
						col1.style.width="25%";
						var col2=document.createElement("td");
						col2.textContent=code;
						col2.style.width="25%";
						var col3=document.createElement("td");
						col3.textContent=branch;
						col3.style.width="25%";
						var col4=document.createElement("td");
						col4.textContent=count;
						col4.style.width="25%";
						//alert(branch);
						row.appendChild(col1);
						row.appendChild(col2);
						row.appendChild(col3);
						row.appendChild(col4);
						table.appendChild(row);

					othis.countcontainer.appendChild(table);
				}
				//alert("populating");
				//othis.populate(students);
				//othis.displaystudents(response);
			}
		}
	}




	this.fetchpf = function()
	{
		othis.xhr.onreadystatechange = othis.showpf;
		othis.xhr.open("GET", "http://localhost/WT2/getrate.php?branch="+document.getElementById("branchpf").value, true);
		othis.xhr.send();
	}
	this.showpf = function()
	{
		if(othis.xhr.readyState==4 && othis.xhr.status==200)
		{
			response=othis.xhr.responseText;
			//alert(response);
			var pf=response.split("newentry");
				othis.pfcontainer=document.getElementById("pfcontainer");
			othis.pfcontainer.innerHTML="";

			if(pf.length==0 || pf.length==1)
			{
				//alert("here");
				othis.pfcontainer.innerHTML="No results returned for your search!";
				othis.pfcontainer.style.color="gray";

				//also let the user know that there were no match
				//othis.movie.className="notfound";

			}

			//else we found match
			//lets add it to the containerdiv

			else
			{
				var i=0;
				othis.pfcontainer.style.color="black";
				var table=document.createElement("table");
				table.style.width="100%";
				var row=document.createElement("tr");
				var head1=document.createElement("th");
				head1.textContent="Branch";
				head1.style.width="30%";
				var head2=document.createElement("th");
				head2.textContent="Elective";
				head2.style.width="30%";

				var head3=document.createElement("th");
				head3.textContent="Code";
				head3.style.width="30%";
				var head4=document.createElement("th");
				head4.textContent="F-Grades";
				head4.style.width="30%";

				table.appendChild(head1);
				table.appendChild(head2);
				table.appendChild(head3);
				table.appendChild(head4);


				for(i=0;i<pf.length-1;i++)
				{
					var count=pf[i].split(",");


						var branch=count[0];
						var name=count[1];
						var code=count[2];
						var fail=count[3];


						var row=document.createElement("tr");
						var col1=document.createElement("td");
						col1.textContent=branch;
						col1.style.width="30%";
						var col2=document.createElement("td");
						col2.textContent=name;
						col2.style.width="30%";
						var col3=document.createElement("td");
						col3.textContent=code;
						col3.style.width="30%";
						var col4=document.createElement("td");
						col4.textContent=fail;
						col4.style.width="30%";
						//alert(branch);
						row.appendChild(col1);
						row.appendChild(col2);
						row.appendChild(col3);
						row.appendChild(col4);
						table.appendChild(row);

					othis.pfcontainer.appendChild(table);
				}
				//alert("populating");
				//othis.populate(students);
				//othis.displaystudents(response);
			}
		}
	}



	this.clearcount = function()
	{
		othis.countcontainer=document.getElementById("countcontainer");
		othis.countcontainer.innerHTML="";
		document.getElementById("branchcount").value="";
	}

	this.clearsearch = function()
	{
		othis.containerdiv=document.getElementById("container");

		var ng=document.getElementById("ng");
		othis.containerdiv.style.border="none";

		othis.studenttable=document.getElementById("studenttable");
		othis.studenttable.innerHTML="";
		othis.containerdiv.innerHTML="";

		ng.textContent="";
		document.getElementById("usn").value="";
	}
	this.clearpf = function()
	{
		othis.pfcontainer=document.getElementById("pfcontainer");
		othis.pfcontainer.innerHTML="";
		document.getElementById("branchpf").value="";
	}
}
ob=new Suggest();
