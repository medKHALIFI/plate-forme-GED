// You can find instructions for this file here:
// http://www.treeview.net

// Decide if the names are links or just the icons
USETEXTLINKS = 1  //replace 0 with 1 for hyperlinks

// Decide if the tree is to start all open or just showing the root folders
STARTALLOPEN = 0 //replace 0 with 1 to show the whole tree

ICONPATH = '././img/' //change if the gif's folder is a subfolder, for example: 'images/'


foldersTree = gFld("<i>Treeview Demo</i>", "demoFramesetRightFrame.html")
  aux1 = insFld(foldersTree, gFld("Photos example", "demoFramesetRightFrame.html"))
    aux2 = insFld(aux1, gFld("United States", "http://www.treeview.net/treemenu/demopics/beenthere_america.gif"))
      insDoc(aux2, gLnk("R", "Boston", "http://www.treeview.net/treemenu/demopics/beenthere_boston.jpg"))
      insDoc(aux2, gLnk("R", "New York", "http://www.treeview.net/treemenu/demopics/beenthere_newyork.jpg"))
      insDoc(aux2, gLnk("R", "Washington", "http://www.treeview.net/treemenu/demopics/beenthere_washington.jpg"))
    aux2 = insFld(aux1, gFld("Europe", "http://www.treeview.net/treemenu/demopics/beenthere_europe.gif"))
      insDoc(aux2, gLnk("R", "Edinburgh", "http://www.treeview.net/treemenu/demopics/beenthere_edinburgh.gif"))
      insDoc(aux2, gLnk("R", "London", "http://www.treeview.net/treemenu/demopics/beenthere_london.jpg"))
      insDoc(aux2, gLnk("R", "Munich", "http://www.treeview.net/treemenu/demopics/beenthere_munich.jpg"))
      insDoc(aux2, gLnk("R", "Athens", "http://www.treeview.net/treemenu/demopics/beenthere_athens.jpg"))
      insDoc(aux2, gLnk("R", "Florence", "http://www.treeview.net/treemenu/demopics/beenthere_florence.jpg"))
      //The next three links have their http protocol appended by the script
      insDoc(aux2, gLnk("Rh", "Pisa", "www.treeview.net/treemenu/demopics/beenthere_pisa.jpg"))
      insDoc(aux2, gLnk("Rh", "Rome", "www.treeview.net/treemenu/demopics/beenthere_rome.jpg"))
      insDoc(aux2, gLnk("Rh", "Lisboa", "www.treeview.net/treemenu/demopics/beenthere_lisbon.jpg"))
  aux1 = insFld(foldersTree, gFld("3 Types of folders", "javascript:parent.op()"))
    aux2 = insFld(aux1, gFld("Linked", "http://www.treeview.net/treemenu/demopics/beenthere_unitedstates.gif"))
      insDoc(aux2, gLnk("R", "New York", "http://www.treeview.net/treemenu/demopics/beenthere_newyork.jpg"))
    aux2 = insFld(aux1, gFld("Empty, linked", "http://www.treeview.net/treemenu/demopics/beenthere_europe.gif"))
    //NS4 needs the href to be non-empty to process other events such as open folder,
    //hence the op function
    aux2 = insFld(aux1, gFld("Not linked", "javascript:parent.op()"))
      insDoc(aux2, gLnk("R", "New York", "http://www.treeview.net/treemenu/demopics/beenthere_newyork.jpg"))
  aux1 = insFld(foldersTree, gFld("Targets", "javascript:parent.op()"))
      insDoc(aux1, gLnk("R", "Right frame", "http://www.treeview.net/treemenu/demopics/beenthere_edinburgh.gif"))
      insDoc(aux1, gLnk("B", "New window", "http://www.treeview.net/treemenu/demopics/beenthere_london.jpg"))
      insDoc(aux1, gLnk("T", "Whole window", "http://www.treeview.net/treemenu/demopics/beenthere_munich.jpg"))
      insDoc(aux1, gLnk("S", "This frame", "http://www.treeview.net/treemenu/demopics/beenthere_athens.jpg"))
      // The S target is required and the \\\ before the ' for string arguments are required too
      // If you define your function in the parent frame, use  javascript:parent.myfunc
      insDoc(aux1, gLnk("S", "JavaScript link", "javascript:alert(\\\'This JavaScript link simply calls the built-in alert function,\\\\nbut you can define your own function.\\\')"))


  aux1 = insFld(foldersTree, gFld("Other icons", "javascript:parent.op()"))
  aux1.iconSrc = ICONPATH + "diffFolder.gif"
  aux1.iconSrcClosed = ICONPATH + "diffFolder.gif"
    docAux = insDoc(aux1, gLnk("B", "D/L Treeview", "http://www.treeview.net/treemenu/download.asp"))
    docAux.iconSrc = ICONPATH + "ftvimage.gif"


  aux1 = insFld(foldersTree, gFld("<font color=red>F</font><font color=blue>o</font><font color=pink>r</font><font color=green>m</font><font color=red>a</font><font color=blue>t</font><font color=brown>s</font>", "javascript:parent.op()"))
    docAux = insDoc(aux1, gLnk("R", "<div class=specialClass>CSS Class</div>", "http://www.treeview.net/treemenu/demopics/beenthere_newyork.jpg"))

