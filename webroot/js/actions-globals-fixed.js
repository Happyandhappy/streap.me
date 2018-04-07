// Set some basic constants
const MIN_ACTIONS = 1;
const MAX_ACTIONS = 8;

// Build an array of providers
var providers = [
	"YouTube",
	"Social Media",
	"Music",	
	"Other Things",
];

var social = [
	"Instagram",
	"Snapchat",
	"Twitter",		
	"Vkontakte",  //https://vk.com/
	"ASKfm",      //https://ask.fm/
	"Discord",    //https://discord.com/
];

var socialLabels = [
	["Watch My Story", "Visit XXX Instagram", "Send Direct Message"],
	["Add Me on Snapchat", "Watch My Story", "Snap Me Something", "Screenshot my SC Story"],
	["Watch My Story", "Visit My Twitter", "Send Direct Message"],
	["Follow Me", "Like This Post", "Send Direct Message","Comment this Post"],
	["Ask Me", "Follow Me"],
	["Join Me"],
];

var providerLabels = [
	[	"Like This Video", 
		"Subscribe TO XXX On Youtube", 
		"Subscribe & Like The Video", 
		"Subscribe & Turn On Notifications", 
		"Comment On This Video", 
		"Dislike This Video", 
		"Watch This Video", 
		"Share This Video", 
		"Check Out XXX Channel", 
		"Check Out This Video"
	],
	[],
	["Stream on Spotify", "Stream on Soundcloud", "Stream on Apple Music"],
];


var music = [
	"Spotify/Apple Music",
	"SoundCloud",
]


var musicLabels = [
	["Save this song", "Save this playlist" , "Listen to this song" , "Follow me on Spotify/Apple Music"],
	["Save This Song", "Save This Playlist", "Listen To This Song", "Like my song" , "Comment under my song", "Follow me on Soundcloud", "Repost my Song"]
];

var type = {
	"Like This Video"			 		:	"like-video", 
	"Subscribe TO XXX On Youtube"		:	"subscribe" , 
	"Subscribe & Like The Video" 		: 	"subscribe-like",
	"Subscribe & Turn On Notifications" : 	"subscribe-notifications",
	"Comment On This Video" 			: 	"comment-video",
	"Dislike This Video" 				: 	"dislike",
	"Watch This Video" 					: 	"watch",
	"Share This Video" 					: 	"share",
	"Check Out XXX Channel" 			: 	"visit-channel",
	"Check Out This Video" 				:	"visit-video",
	"Watch My Story" 					: 	"watch-story",
	"Visit XXX Instagram" 				: 	"visit-instagram",
	"Send Direct Message" 				: 	"dm",
	"Add me on Snapchat" 				: 	"add",
	"Snap Me Something" 				:	"snap",
	"Screenshot my SC Story" 			: 	"screen",
	"Save This Song" 					: 	"save",
	"Save This Playlist" 				: 	"save-playlist",
	"Listen To This Song" 				: 	"listen",
	"Follow Me On Spotify/Apple Music" 	: 	"follow-music",
	"Follow Me" 						: 	"follow",
	"Like This Post" 					: 	"like",
	"Comment this Post" 				: 	"comment",
	"Ask Me" 							:	"ask",
	"Join Me"							:	"join",
	"Visit My Twitter"					:	"visit-twitter",

};
function populateSelect(jqueryObject, optionList, useIndex = true)
{
	jqueryObject.append('<option value="">Choose One...</option>');
	$(optionList).each(function(index) {
		if (useIndex) {
			jqueryObject.append('<option value="' + index + '">' + this + '</option>');
		} else {
			jqueryObject.append('<option value="' + this + '">' + this + '</option>');
		};
	});
};