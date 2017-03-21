/*Si la souche est cochée dans "présentes dans" alors on ne peut plus la cocher dans "absentes dans" sinon elle peut être cochée*/
function putEnabled(source)
{
	check = document.querySelectorAll("#div1 input");
	Nocheck = document.querySelectorAll("#div2 input");
	for (var i=0, n=check.length;i<n;i++)
	{
		if(check[i].checked == true)
		{
			Nocheck[i].disabled = true;
		}
		else
		{
			Nocheck[i].disabled = false;
		}
	}
}

/*Si la souche est cochée dans "absentes dans" alors on ne peut plus la cocher dans "présentes dans" sinon elle peut être cochée*/
function makeEnabled(source)
{
	check = document.querySelectorAll("#div1 input");
	Nocheck = document.querySelectorAll("#div2 input");
	for (var i=0, n=Nocheck.length;i<n;i++)
	{
		if(Nocheck[i].checked == true)
		{
			check[i].disabled = true;
		}
		else
		{
			check[i].disabled = false;
		}
	}
}

/*Bouton pour cocher tout ce qui est disponible dans "présentes dans"*/
function clickAll()
{
	check = document.querySelectorAll("[name^=NomS]");
	for (var i=0, n=check.length;i<n;i++)
	{
		if(check[i].disabled == false)
		{
			check[i].checked = true;
		}
	}
	cPro = document.querySelectorAll("[name^=proteome]");
	cPro[0].checked = true;
	putEnabled();
}

/*Bouton pour tout décocher*/
function declickAll()
{
	check = document.querySelectorAll("[name^=NomS]");
	for (var i=0, n=check.length;i<n;i++)
	{
		check[i].checked = false;
	}
	putEnabled();
}

/*Bouton pour cocher tout ce qui est disponible dans "absentes dans"*/
function clickAllWithout(source)
{
	check = document.querySelectorAll("#div1 input");
	Nocheck = document.querySelectorAll("#div2 input");
	for (var i=0, n=check.length;i<n;i++)
	{
		if(check[i].checked == false)
		{
			Nocheck[i].checked = true;
		}
	}
	makeEnabled();
}

/*Bouton pour tout décocher*/
function declickAllWithout()
{
	check = document.querySelectorAll("[name^=NoNomS]");
	for (var i=0, n=check.length;i<n;i++)
	{
		check[i].checked = false;
	}
	makeEnabled();
}