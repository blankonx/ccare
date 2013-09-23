Welcome to the fogLoader 0.9.1 Read Me

send all comments and questions to ccamp@onebox.com
Thanks for using!

Basic Usage:

	html:
	<div id="loader"></div>
	
	script:
	$('#loader').fogLoader();
	
Use with options
	html:
	<div id="loader"></div>
	
	script:
	$('#loader').fogLoader({
		message: 'Working',
		animated: true,
		progressChar: '-',
		progressDelay: 300,
		height: 40,
		borderRadius: '12px'
	});
	
Progress Bar
	html:
	<div id="loader"></div>
	
	script:
	$('#loader').fogLoader({
		style: 'progressbar',
		progressValue: 25

	});

	

=======================================================================================================================
Options:

Option				Description							Type	Options					Default		UI Dialog Extension
----------			--------------------------------	------	--------------------	-------		-------------------
message				The text displayed on the dialog  	string							Loading		N

animated			Indicates if the ellipses will
					be actively displayed				boolean							true		N
					
closeOnEscape 		Enables the ESC key to close the
					dialog (extension of UI Dialog)		boolean							true		Y
					
height				The height of the dialog			int								25			Y

maxHeight 			The maximum height of the dialog	int								false		Y

maxWidth			The maximum width of the dialog		int								false		Y

minHeight			The minimum height of the dialog	int								15			Y

minWidth 			The minimum width of the dialog		int								20			Y

position			The position of the dialog on the
					dialog on the page					string							center		Y
					
width				The width of the dialog				int								130			Y

textAlign			The text aligment of the message
					in the dialog						string							center		N
					
wrapText			Sets white-space CSS property of 
					dialog text							string	see white-space CSS		nowrap		N
					
fontSize			The font size of the message		string							1.2em		N

fontFamily			The font family of the message		string							null		N

fontWeight			The font weight of the message		string							normal		N

borderRadius		The border radius of the dialog. 
					Note this will override any radii
					set from the theme					int								null		N
					
borderWidth			The border with of the dialog		string							1px			N

style				Indicates where to show dialog
					as a message or a progress bar 		string	'message','progressbar'	message		N
					
progressMax			The maximum lenght of the
					animated message before it resets	int								10			N
					
progressChar		The trailing characters of an
					animated message					string							.			N
					
progressSpell		Indicates if the message should be
					spelled out							boolean							false		N
					
progressDelay		The speed at which the animation
					will run							int								250			N
					
progressBarImage	The path to the imaged used to 
					show an animated progress bar		string							null		N
					
progressValue		The value of the progress bar		int								0			N

=============================================================================================================

Methods

close				Closes the dialog						$(selector).fogLoader('close');
destroy				Destroys the dialog						$(selector).fogLoader('destroy');
updateProgress		Updates the progress value on screen	$(selector).fogLoader('updateProgress', progValue);	