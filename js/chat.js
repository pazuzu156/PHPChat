function Smiles(emote)
{
	document.message.usermsg.value = document.message.usermsg.value + emote;
	document.message.usermsg.focus();
	document.message.usermsg.select();
}

$(function()
{
	//initial load
	apiLoadLog();
	apiLoadUsers();

	$("#clear").click(function(e)
	{
		e.preventDefault();

		var clear = confirm("Are you sure you wish to clear the chat log?");
		if(clear===true)
			apiClear();
	});

	$("#usermsg").click(function()
	{
		if($(this).val()=="Please type in a message!")
			$(this).attr("value", "").removeClass("error");
	});

	$("#submitmsg").click(function(e)
	{
		e.preventDefault();

		var msg = $("#usermsg"),
			username = $("#username").val();

		if(msg.val()==="")
			msg.addClass("error").attr("value", "Please type in a message!");
		else if(msg.val()==="Please type in a message!")
			msg.addClass("error").attr("value", "Please type in a message!");
		else
		{
			apiPush({msg: msg.val(), user: username});
			msg.val('');
		}
	});

	setInterval(apiLoadLog, 1000);
	setInterval(apiLoadUsers, 1000);
});

function apiLoadLog()
{
	var oldScrollHeight = $("#chatbox").prop('scrollHeight') - 20;
	$.ajax({
		type: 'get',
		url: 'api.get',
		dataType: 'html',
		success: function(data, status, xhr)
		{
			var box = $("#chatbox");
			box.html(data);
			var newScrollHeight = box.prop('scrollHeight') - 20;
			if(newScrollHeight > oldScrollHeight)
				box.animate({scrollTop: newScrollHeight}, 'slow');
		}
	});
}

function apiLoadUsers()
{
	$.ajax({
		type: 'get',
		url: 'api.users',
		success: function(data, status, xhr)
		{
			$("#users").html(data);
		}
	});
}

function apiPush(pushData)
{
	$.ajax({
		type: 'post',
		url: 'api.push',
		data: pushData,
		dataType: 'json',
		success: function(data, status, xhr)
		{
			if(data.error === true)
			{
				$("#usermsg").val(pushData.msg).focus();
				alert(data.msg);
			}
		},
		error: function(xhr, status, error)
		{
			alert("Error: " + error + " // Status: " + status);
		}
	});
}

function apiClear()
{
	$.ajax({
		type: 'post',
		url: 'api.clear',
		dataType: 'json',
		success: function(data, status, xhr)
		{
			alert(data.msg);
		},
		error: function(xhr, status, error)
		{
			alert("Error: " + error + " // Status: " + status);
		}
	});
}