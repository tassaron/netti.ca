<?php

// It's pretty well impossible to access this, but regardless...
if ($_SESSION['authorized']==false OR $_SESSION['cgroup'] != 7)
{
	die();
}

?>

<p>Confused about some aspects of the admin panel? You've come to the right place. The admin panel on Nettica can be an unintuitive, confusing beast 
for someone unfamiliar with it. But gaining administrative powers on Nettica is a sign of trust from the other administrators, so clearly they thought 
you had something to contribute. This document should give you a pretty thorough idea of how to use your powers, and how you can help make Nettica 
a better game for everyone!</p>

<ol>
<li><a href="#1">phpMyAdmin</a></li>
<li><a href="#2">Items</a></li>
<li><a href="#7">Hostile programs</a></li>
<li><a href="#3">Internet</a></li>
<li><a href="#4">Contracts</a></li>
<li><a href="#5">Systems</a></li>
<li><a href="#6">Objects</a></li>
</ol>

<p><span class="highlight"><a name="1">phpMyAdmin</a></span><br>
This is the highest level of administrative power; it provides the user with a simple graphical interface with which to manually edit the 
MySQL database that powers Nettica. Access to phpMyAdmin could very quickly and easily destroy the entire website, so a second password is required. 
Using it properly requires intimate knowledge of the game's programming, so, if you need to read this help file, you probably don't know enough 
about the game to be using it. If for any reason you think something needs to be done in phpMyAdmin, contact the lead programmer, 
<a href="/profile.php?id=1">Bran</a>.</p>

<p><span class="highlight"><a name="2">Items</a></span><br>
Administrators have the power to add, edit, and delete items from the game with more precision than ordinary users. As an admin, you have the ability 
to create items with any power level that use any amount of memory regardless of your in-game skills. These are the items that are found in the 
shops, on the <a href="#3">internet</a>, or within various <a href="#5">systems</a> and given out by <a href="#6">objects</a>.<br><br>

The key attributes of an item are as follows:</p><ul>
<li><span class="highlight">Name:</span> Obviously, this is the name of the item as it appears in the game. Unlike normal users, admins are expected to maintain a certain level of 
quality with their names; these will be seen as "official" items by the users, after all. Make your item name appropriate to the overall look and feel 
of Nettica, while still providing a clue as to its function. Humour (such as a pun) is always a plus.<br><br></li>
<li><span class="highlight">Type:</span> These should hopefully be self-explanatory to anyone who's played the game before. Note that if your item is available in shops, the type 
determines which shop it will be in (software or hardware). The two types you may not be familiar with are Unknown and Special, which, as stated on 
the item creation screen, should be used only when necessary. Unknown is generally just a "glitch" item type, reserved for use by the programmers; 
don't ever use it. Special is an as-of-yet undefined type that is reserved for future use; again, don't ever use it.<br><br></li>
<li><span class="highlight">Power:</span> As an admin, you can create items with any power from 0 to 999 regardless of your in-game stats. This number just tells the game how good 
the item is, how it should be included in combat calculations, etc. Higher numbers are stronger, but don't go too high or you could unbalance the 
game (nothing worse than one set of items that is objectively the best).<br><br></li>
<li><span class="highlight">Memory:</span> Same as the power, but backwards (sort of). The higher this number, the more memory the item will require to be installed and used by 
someone in the game. Ordinary users have memory and power dynamically determined by their programming skill to always be roughly in balance, but 
admins have no restriction; you can make very bad items that use a lot of memory, or very good items that don't use much memory, or keep the two 
values close to one another for a fair balance. Whatever you choose, make sure to keep game balance in mind -- do not make overpowered items. 
Also note that this value doesn't affect hardware (items of type CPU, Bandwidth, Memory, or Special), so you can just leave it at zero in those 
cases. (The power of Memory-type items is determined by the power value, not the memory value.)<br><br></li>
<li><span class="highlight">Cost:</span> How much the item will be sold for in the shop. You can safely leave this field blank if your item won't appear in the shop, but it's 
better to set a reasonable number just in case it's ever needed. The cost should be reasonable, taking the memory and power values into account as 
well as the type (hardware is generally more expensive, as it affects the game in a more meaningful way). Look at other items in the game to get an 
idea as to the value of money.<br><br></li>
<li><span class="highlight">Available in the shop?</span> The default option is "no". The shops are just a quick and dirty place to get items; most items should be given out by 
<a href="#6">objects</a>, to encourage exploration of the <a href="#3">internet</a> and completion of <a href="#4">contracts</a>.<br><br></li>
<li><span class="highlight">Description:</span> You have <?php echo $maxbiolength; ?> characters to describe your item memorably and informatively. Like the name of the item, 
this is the place where you should be conforming to Nettica's overall look and feel. Give the item an interesting backstory or something.</li>
</ul>

<p>Although there is an option to delete items from the game, <span class="highlight">do not delete anything unless absolutely necessary</span>. People get 
attached to their posessions in the game, and in most cases it is better to retire an item by removing all methods of attaining it (take it out of 
the shops, edit any objects that might reference it, etc). Deleting an item will remove it from the game entirely as if it never existed, while 
retiring it will allow any users who had it on their hard drives to continue having it. If the item is game-breaking in some way (by being 
overpowered, too cheap, or whatever), you can edit the item to be weaker.</p>

<p><span class="highlight"><a name="7">Hostile programs</a></span><br>
Hostile programs are essentially the "enemies" of Nettica. Although a large part of the game should ideally be spent hacking other users, <a href="#5">
systems</a> require computer-controlled enemies to provide a challenge to the user. Creating a hostile program here has no effect on the game until 
you include the program in a system with an <a href="#6">object</a>.<br><br>

The key attributes of a hostile program are as follows:</p><ul>
<li><span class="highlight">Name:</span> Obviously, this is the name of the program as it appears in the game. Make the name appropriate to the 
overall look and feel of Nettica and of the system in which you plan to place the hostile program. The name should ideally provide a clue as to 
the program's best attributes (example: a hostile program that is easy to deceive could be called "ernest.exe"). Humour (such as a pun) is always 
a plus.<br><br></li>
<li><span class="highlight">Attack:</span> The program's ability to harm the user when it attacks. Although a user's ability to harm is determined 
by several different variables in conjunction (attack, virus, firmware), hostile programs just have one that stands in for all of them.<br><br></li>
<li><span class="highlight">Defence:</span> The program's inability to take damage from the user when they attack. Although a user's ability to 
defend is determined by several different variables in conjunction (defence, shield, firmware), hostile programs just have one that stands in for 
all of them.<br><br></li>
<li><span class="highlight">Intelligence:</span> The program's inability to be fooled by the user's deceive program. The higher the number, the 
harder the program is to deceive (meaning that the user needs higher stealth, a better deceive program, and/or a firmware update). Consider whether 
you really want the user to fight this program or not when setting this value; if you make every hostile program totally immune to deception, it 
renders the user's entire set of stealth statistics pointless, but if you make every program too gullible you'll make the system too easy to get 
through without taking any damage. You need to maintain a balance.<br><br></li>
<li><span class="highlight">Description:</span> You have <?php echo $maxbiolength; ?> characters to describe the hostile program memorably and 
(maybe) informatively. Like the name, this is the place where you should be conforming to Nettica's overall look and feel. Give the hostile program 
an interesting backstory or something.</li>
</ul>

<p><span class="highlight"><a name="3">Internet</a></span><br>
You should have a rough idea of how the internet works if you've ever played Nettica (as you should have, if you're an admin). Still, it's worth 
reviewing some of the things about the internet that you might not have noticed before you became an administrator. The internet is divided into 
networks, which are further divided into nodes (the squares you see on the map). A node can also contain <a href="#4">contracts</a>, though it's 
not necessary.<br><br>

Networks are just meaningless subdivisions of the internet for the purposes of organization; they have no actual gameplay effect, but they're still 
important. The current network is displayed above the map on every screen of the internet, and is used like a neighbourhood or a city to easily 
identify different groups of nodes. A node must always be in a network. If you delete a network, make sure to edit any nodes that were in it to 
place them in a different (non-deleted) network. Networks should be contiguous (i.e., all the nodes in a network should be connected to one 
another), though they do not have to be.<br><br>

Nodes are a bit more complicated:</p><ul>
<li><span class="highlight">Name:</span> The name of the node, obviously. It can be the same as another node if it is part of a group of "filler" 
nodes (i.e., nodes that exist primarily to fill up space and make the internet feel bigger). The name should be capitalized like the name of a 
place (a proper noun).<br><br></li>
<li><span class="highlight">Tile:</span> This is the URL to the image (tile) that will be used to represent this node on the map. Tiles should be 
located in the /img/ directory on netti.ca to ensure uptime and for the sake of professionalism -- contact a programmer such as 
<a href="/profile.php?id=1">Bran</a> to upload a tile, or to request that a tile be created. If you don't have a tile for your node, you may leave 
the default URL in this field to indicate that the node does not yet have a tile (represented on the map by a white question mark).<br><br></li>
<li><span class="highlight">Network:</span> As discussed above, a node's network is like a neighbourhood used to connect it with other nodes. In 
most cases, a node should not be the only one in its network, and other members of its network should be nearby (not separated or scattered across 
the entire internet).<br><br></li>
<li><span class="highlight">Coordinates:</span> Two numbers from 0 to 9999 that tell the game where the node is located on the internet. The first 
number is for the x-axis (horizontal) and the second is for the y-axis (vertical). If you imagine the internet as a giant grid, 0,0 would 
be at the absolute bottom-left. Make sure to put your node directly beside or above another node on the internet or else no one will be able to 
actually go there in the game. A simple way to figure out where your node should be is to go to the node next to where you want to put it, 
hover your mouse over the navigation button that would lead to your node, and copy the URL -- it will contain x and y coordinates that you can then 
use in the admin panel to place your node. <span class="highlight">Do not place two nodes at the same coordinates.</span><br><br></li>
<li><span class="highlight">Directions:</span> Simply indicates which directions the user can go from this node. In most cases, all directions should 
be checked, but some may not be if your node is near a wall or other obstacle on the internet. Make sure to edit other nodes to match yours if you 
decide to prohibit movement in a certain direction. (Example: if you create a node at 500,500 from which users can't move right, make sure to edit 
the node at 501,500 to make it so users can't move left.)<br><br></li>
<li><span class="highlight">Description:</span> You have <?php echo $maxtextarealength; ?> characters to describe your node. This is the text that 
is shown to the left of the map, before all the other information about the node. It should be reasonably detailed and properly written; even if you 
have no important information to impart, give it some flavour text. Be creative with your descriptions to make the internet feel lived in.</li></ul>

<p><span class="highlight"><a name="4">Contracts</a></span><br>
Contracts serve two important functions: firstly they act as the actual contracts that people complete in the game (duh), and secondly they serve 
as identification for <a href="#5">systems</a>. Systems cannot exist outside of a contract, even if the contract does not have any actual qualities 
of what you would think of as a "contract" -- that is, the contract does not have to be an actual agreement between the user and a third party to 
complete some task; many contracts are just gateways to open systems that anyone can explore, with no set goals.

Key elements of a contract:</p><ul>
<li><span class="highlight">Name:</span> The name of the contract. This is the name that appears on the contract list if your contract is listed 
there, so make it reasonably descriptive of what the contract is about. Even if unlisted, your contract should be given a name as this name will 
still appear when users complete the contract's system. If you don't plan to give the contract's system a win condition (making it uncompletable), 
this field can be left blank.<br><br></li>
<li><span class="highlight">System:</span> The name of the contract's system. This field must be completed no matter what, as a contract without 
a system would have no purpose. You may give your system the same name as another system in the game, but only with good reason.<br><br></li>
<li><span class="highlight">Coordinates:</span> Two numbers from 0 to 9999 that tell the game where the contract is located on the <a href="#3">internet</a>. 
The first number is for the x-axis (horizontal) and the second is for the y-axis (vertical). If you imagine the internet as a giant grid, 0,0 would 
be at the absolute bottom-left. <span class="highlight">Make sure to place your contract at the same coordinates as a node</span> or else no one 
will be able to access it. A simple way to figure out where your contract should be is to go to the node below where you want to put it, hover your 
mouse over the upwards navigation button that would lead to that node, and copy the URL -- it will contain x and y coordinates that you can then 
use in the admin panel to place your contract. You may put multiple contracts on one node, but only do so when it makes logical sense (and try not 
to let too many contracts appear on a node at the same time for any given user; it looks messy).<br><br></li>
<li><span class="highlight">Description:</span> You have <?php echo $maxtextarealength; ?> characters to describe your contract. This is the 
text that appears when users find your contract in the contract list, meaning that it should give a backstory for the contract and tell the user 
what the winning conditions for the contract's system are, as well as probably telling them where the system is. Like any other description, it 
should be creative, interesting, and properly written. Feel free to string multiple contracts together and tell a story in their descriptions; 
it makes the internet of Nettica feel more like a real place. Humour is always a plus. If your contract is unlisted, this field can be left blank.
<br><br></li>
<li><span class="highlight">Listed?</span> Whether or not your contract is listed in the contract list. Unlike items, which should be kept hidden 
to encourage exploration, contracts by their very nature require exploration to complete. In fact, making your contract listed can give users more 
incentive to browse Nettica's internet, so listing it is usually a good idea. However, it would be really strange if all contracts were listed, as 
making your contract listed makes it so users must accept the contract prior to entering the system; unlisted contracts can have their systems entered 
at any time as long as the user meets the level restriction. In general, there should be a decent mix of listed and unlisted contracts in the game. 
Try to make sure no levels are left without any listed contracts, and consider making unlisted contracts for levels that don't have many. Mix it up!
<br><br></li>
<li><span class="highlight">Level restriction:</span> A number from 1 to 999 that indicates the minimum level a user must be in order to enter the 
contract's system or to see the contract on the contract list. It's usually a good idea to set it a few levels lower than necessary so that users 
have a chance to challenge themselves; but don't just set every level restriction to 1 in order to get more people in your systems. Cut it off at 
the point where users are likely to get themselves killed (i.e., their physical health hits 0%). It's okay to make a dangerous contract, but limit 
it to people who could reasonably be expected to cope.</li></ul>

<p>You also have the option to delete contracts from the game. Unlike most other actions of deletion, which totally remove things from the game, the 
contract deletion is very "soft" -- people who are in the contract's system will be allowed to stay there and even complete the contract if it can 
be completed. People who have already completed the contract will continue to see the contract information along with all the other contracts they've 
completed. Deleting makes the contract's system inaccessible to people who are not already in it and removes the contract from the contract list if 
necessary.</p>

<p><span class="highlight"><a name="5">Systems</a></span><br>
Systems and <a href="#6">objects</a> are collectively the most important and most confusing aspects of Nettica. A few keys things to know about 
systems:</p><ol>
<li>Every system is part of a <a href="#4">contract</a>, whether it can be "completed" or not.</li>
<li>A system is unique to each user. Unlike the internet and nodes which are a public zone, a user in a system is alone; other users in the system 
are not visible and have no effect on that user's unique instance of the system.</li>
<li>The majority of systems should sprawl out more than necessary like an actual system (in real life) would. They should not just be straight lines 
to a goal.</li>
<li><span class="highlight">All systems contain objects!</span> They should never be empty, as that would just be a waste of people's time.</li>
</ol>
<p>Note that the screen you see when working on a new system is a screen to create part of the system, not the entire thing; systems comprise 
squares that make up the map of the system, like nodes on the internet. A system should contain a lot of different "parts", not just one. Bearing 
that in mind, these are the key elements of a system that you will see in the admin panel:</p><ul>
<li><span class="highlight">Contract:</span> Pick a contract's system from this list to attach this part of a system to that contract's system.
<br><br></li>
<li><span class="highlight">Coordinates:</span> Two numbers from 0 to 9999 that tell the game where this part is located within the system. 
The first number is for the x-axis (horizontal) and the second is for the y-axis (vertical). If you imagine the system as a giant grid, 0,0 would 
be at the absolute bottom-left. Though it may seem reasonable, it's generally not a good idea to put the entrance to the system in a 
corner such as 0,0 or 9999,9999 -- put it in the middle so you can make the system sprawl out in all directions without being confined by invisible 
game boundaries. Note that, although it uses the same coordinate system as everything else, <span class="highlight">these coordinates actually 
refer to a part's location within the system, not on the internet</span>; the entire system is in fact located at the coordinates of the system's 
contract.<br><br></li>
<li><span class="highlight">Type:</span> A part in a system can either be an entrance, an exit, or nothing. Most parts should be nothing. If this 
part is an exit, it means that users can leave the system and return to the node on the internet from which they entered. Generally you want to 
scatter a few exits throughout the system so that users have a chance to leave, but not so many exits that there's no penalty for biting off more 
than you can chew. An exit after a particularly hard part of a system (a part with a lot of hostile objects, for example) is usually a good idea. 
Entrances serve the same purpose as exits, except that the system can only contain one of them. The entrance is where the user first appears in the 
system after entering it from a node on the internet. If you accidentally make more than one entrance, the game will start the user at the first one 
you created and all subsequent entrances will be treated as exits. <span class="highlight">A system with no entrance cannot be entered at all.</span>
<br><br></li>
<li><span class="highlight">Objects:</span> Any given part of a system can contain up to nine <a href="#6">objects</a>, which are necessary for 
the system to have any point. Not every part of the system needs to have objects, but most should.<br><br></li>
<li><span class="highlight">Description:</span> You have <?php echo $maxtextarealength; ?> characters to describe this part of the system. This is 
the flavour text that appears to the left of the map when the user is inside this part of the system. Usually the entrances and exits of the system 
should contain some description, as well as any important rooms (with a lot of objects, especially if they contain an object that can trigger the 
win condition). It's fine to leave this field blank for most of the parts in your system. Like any other description in Nettica, it should be 
creative, interesting, and properly written.</li></ul>

<p><span class="highlight"><a name="6">Objects</a></span><br>
Objects are the things that make systems tick. Although an object only has a few properties, it is an essential part of Nettica. Basically, an object 
is an instance that appears in systems that has the following properties:</p><ul>
<li><span class="highlight">Type:</span> Indicates what the object is, whether it be an <a href="#2">item</a> or a <a href="#7">hostile program</a>. 
Items that do not appear in the shops should be referenced by an object somewhere in Nettica so that they can actually be attained by the users. It 
is perfectly acceptable to create a new item or hostile program just for your system, even if you're only going to use it once. In fact, creating a 
new item that ONLY appears in your system could be a good way to draw people's interest; however, as stated above, do not make items overpowered 
just to garner attention. Hostile programs can kill the user, and should thus be placed in accordance with the system's level restriction.<br><br></li>
<li><span class="highlight">Before conditions:</span> These are the conditions in effect "before" the object has been properly dealt with. Ways for 
the user to get past the before conditions would be destroying the object, deceiving it (if a hostile program) or stealing it (if an item).<br><br></li>
<li><span class="highlight">After conditions:</span> These are the conditions in effect "after" the object has been properly dealt with. Ways for 
the user to see these these conditions in action would be destroying the object, deceiving it (if a hostile program) or stealing it (if an item).<br><br>
The possible conditions are:<ol>
<li><span class="highlight">Can/can't go &lt;direction&gt;:</span> The user can't or can move in the indicated direction.</li>
<li><span class="highlight">Can/can't win:</span> The user can't win until the object has been dealt with, or will win after the object has been dealt
with. Creating multiple objects with "can't win" and "can win" as before and after conditions will allow you to force the user to deal with more 
than one object. If you only have one (or no) objective in the system's <a href="#4">contract</a>, this condition serves no real purpose.</li>
<li><span class="highlight">Can/can't steal local:</span> The user can't or can steal any items in this part of the system.</li>
<li><span class="highlight">Can/can't steal global:</span> The user can't steal any items from ANY part of the system.</li>
<li><span class="highlight">Can/can't exit:</span> The user can't or can leave the system from this area (the area must be an exit for this condition 
to have any effect; it does not affect entrances, which are always accessible for the sake of fairness).</li>
</ol><br><br></li>
<li><span class="highlight">Message if destroyed:</span> This is the message that is displayed if the object is destroyed. It can be up to 
<?php echo $maxtextarealength; ?> characters long and should be appropriate to the situation, describing the consequences of this action in a 
creative and interesting way.<br><br></li>
<li><span class="highlight">Message if other:</span> This is the message that is displayed if the object is deceived (if it's a hostile program) 
or stolen (if it's an item). The message can be up to <?php echo $maxtextarealength; ?> characters long and should be appropriate to the situation, 
describing the consequences of this action in a creative and interesting way.</li></ul>
<p>Bear in mind that not every object needs to have before and after conditions. The conditions exist to give a structure to the system and allow 
you more control in how your system is experienced. Don't give every object a "can't win" before condition just to force the user to spend more 
time in your system; make it sensible.</p>