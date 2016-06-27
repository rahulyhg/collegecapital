/* ------- General functions ------- */

// String - Trim leading and trailing spaces
function trim(str)
{
	return trimString(str,0);
}

// String - Trim leading spaces
function trimL(str)
{
	return trimString(str,1);
}

// String - Trim trailing spaces
function trimR(str)
{
	return trimString(str,2);
}

function trimString(str,option)
{
	var i = 0;
	var j = str.length-1;
	str = str.split("");
	
	// remove all leading spaces
	if ((option==0)||(option==1))
	{
		while(i < str.length)
		{
			if(str[i]==" ")
				str[i] = "";
			else
				break;
		
			i++;
		}
	}
	
	// remove all trailing spaces
	if ((option==0)||(option==2))
	{
		while(j > 0)
		{
			if(str[j]== " ")
				str[j]="";
			else
				break;
		
			j--;
		}
	}
	return str.join("");
}

function toTitleCase(str)
{
	var str = str.split("");
	for (i=0;i<str.length;i++) 
	{
		// capitalise the first character
		if (i == 0) 
			str[i] = str[i].toUpperCase();
		// capitalise every character if a space exists before it
		else if(str[(i-1)]==" ") 
			str[i] = str[i].toUpperCase();
	}
	return str.join("");
}

function formatNumber(v, d)
{
	// v = value (as number or string)
	// d = number of deciaml places returned
	var t = v.toString();                 // convert to string
	if(t.indexOf('.')==-1) t = t + '.';   // find/set decimal location
	var p = t.indexOf('.');               // get decimal loaction
	for(i=0; i<d; i++) t = t + '0';       // pad string with zero's
	return t.substr(0, (p+d+1));          // return formated string (number)
}

