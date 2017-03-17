function clickAll()
{
	check = document.querySelectorAll("[name^=NomS]");
	for (var i=0, n=check.length;i<n;i++)
	{
		check[i].checked = true;
	}
	cPro = document.querySelectorAll("[name^=proteome]");
	cPro[0].checked = true;
}

function declickAll()
{
	check = document.querySelectorAll("[name^=NomS]");
	for (var i=0, n=check.length;i<n;i++)
	{
		check[i].checked = false;
	}
}

function clickAllWithout(source)
{

}

function declickAllWithout()
{
	check = document.querySelectorAll("[name^=NoNomS]");
	for (var i=0, n=check.length;i<n;i++)
	{
		check[i].checked = false;
	}
}
