-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2014 at 02:08 AM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ImanchaOS`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `name_category`, `description`) VALUES
(1, 'Android', 'Everything about android'),
(2, 'Java', 'Everything about java'),
(3, 'C++', 'Everything about C++'),
(4, 'C', 'Everything about C'),
(5, 'C#', 'Everything about C#'),
(6, 'Bootstrap', 'Everything about bootstrap');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `follower` int(11) NOT NULL,
  `date_follow` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `follower` (`follower`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `user_message` varchar(20) NOT NULL,
  `content_message` text NOT NULL,
  `receiver_message` varchar(20) NOT NULL,
  `date_message` datetime NOT NULL,
  `status_message` enum('sent','read') NOT NULL DEFAULT 'sent',
  `user_deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `receiver_deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_message`),
  KEY `user_message` (`user_message`),
  KEY `receiver_message` (`receiver_message`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id_message`, `user_message`, `content_message`, `receiver_message`, `date_message`, `status_message`, `user_deleted`, `receiver_deleted`) VALUES
(1, 'imancha', 'Messages 1', 'imancha', '2014-05-29 22:08:38', 'read', 'N', 'N'),
(2, 'imancha', 'Reply Messages 1', 'imancha', '2014-06-12 23:49:04', 'read', 'N', 'N'),
(3, 'imancha', 'Reply Messages 1.1', 'imancha', '2014-06-12 23:49:46', 'read', 'N', 'N'),
(4, 'imancha', 'Reply Messages 1', 'imancha', '2014-06-12 23:50:22', 'read', 'N', 'N'),
(5, 'imancha', 'Reply Messages 1', 'imancha', '2014-06-12 23:50:26', 'read', 'N', 'N'),
(6, 'imancha', 'Reply Messages 1', 'imancha', '2014-06-12 23:50:30', 'read', 'N', 'N'),
(7, 'imancha', 'Reply Messages 1.1', 'imancha', '2014-06-12 23:50:34', 'read', 'N', 'N'),
(8, 'imancha', 'Reply Messages 12', 'imancha', '2014-06-13 00:13:08', 'read', 'N', 'N'),
(9, 'imancha', 'Reply Messages 1.12345', 'imancha', '2014-06-13 00:13:45', 'read', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `user_notification` varchar(20) NOT NULL,
  `content_notification` text NOT NULL,
  `date_notification` datetime NOT NULL,
  `status_notification` enum('read','sent') NOT NULL,
  PRIMARY KEY (`id_notification`),
  KEY `id_user` (`id_user`),
  KEY `user_notification` (`user_notification`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id_notification`, `id_user`, `user_notification`, `content_notification`, `date_notification`, `status_notification`) VALUES
(1, 1, 'imancha', 'joined ImanchaOS.', '2014-06-02 00:00:00', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_topic` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `content_post` text NOT NULL,
  `date_post` datetime NOT NULL,
  `edit_date_post` datetime DEFAULT NULL,
  `creator_post` varchar(30) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `creator_post` (`creator_post`),
  KEY `id_category` (`id_category`),
  KEY `id_topic` (`id_topic`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id_post`, `id_topic`, `id_category`, `content_post`, `date_post`, `edit_date_post`, `creator_post`) VALUES
(1, 1, 1, '<p>You will be glad to know that you can start your Android application development on either of the following operating systems:</p>\r\n\r\n<ul>\r\n	<li>Microsoft Windows XP or later version.</li>\r\n	<li>Mac OS X 10.5.8 or later version with Intel chip.</li>\r\n	<li>Linux including GNU C Library 2.7 or later.</li>\r\n</ul>\r\n\r\n<p>Second point is that all the required tools to develop Android applications are freely available and can be downloaded from the Web. Following is the list of software&#39;s you will need before you start your Android application programming.</p>\r\n\r\n<ul>\r\n	<li>Java JDK5 or JDK6</li>\r\n	<li>Android SDK</li>\r\n	<li>Eclipse IDE for Java Developers (optional)</li>\r\n	<li>Android Development Tools (ADT) Eclipse Plugin (optional)</li>\r\n</ul>\r\n\r\n<p>Here last two components are optional and if you are working on Windows machine then these components make your life easy while doing Java based application development. So let us have a look how to proceed to set required environment.</p>\r\n\r\n<h3>Step 1 - Setup Java Development Kit (JDK)</h3>\r\n\r\n<p>You can download the latest version of Java JDK from Oracle&#39;s Java site: <a href="http://www.oracle.com/technetwork/java/javase/downloads/index.html" target="_blank">Java SE Downloads</a>. You will find instructions for installing JDK in downloaded files, follow the given instructions to install and configure the setup. Finally set PATH and JAVA_HOME environment variables to refer to the directory that contains <strong>java</strong> and <strong>javac</strong>, typically java_install_dir/bin and java_install_dir respectively.</p>\r\n\r\n<p>If you are running Windows and installed the JDK in C:jdk1.6.0_15, you would have to put the following line in your C:autoexec.bat file.</p>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">set PATH=C:jdk1.6.0_15in;%PATH%<br />\r\nset JAVA_HOME=C:jdk1.6.0_15</div>\r\n\r\n<p>Alternatively, you could also right-click on <em>My Computer</em>, select <em>Properties</em>, then <em>Advanced</em>, then <em>Environment Variables</em>. Then, you would update the PATH value and press the OK button.</p>\r\n\r\n<p>On Linux, if the SDK is installed in /usr/local/jdk1.6.0_15 and you use the C shell, you would put the following code<br />\r\ninto your <strong>.cshrc</strong> file.</p>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">setenv PATH /usr/local/jdk1.6.0_15/bin:$PATH<br />\r\nsetenv JAVA_HOME /usr/local/jdk1.6.0_15</div>\r\n\r\n<p>&nbsp;Alternatively, if you use an Integrated Development Environment (IDE) Eclipse, then it will know automatically where you have installed your Java.</p>\r\n\r\n<h3>Step 2 - Setup Android SDK</h3>\r\n\r\n<p>You can download the latest version of Android SDK from Android official website : <a href="http://developer.android.com/sdk/index.html" target="_blank">Android SDK Downloads</a>. If you are installing SDK on Windows machine, then you will find a <em>installer_rXX-windows.exe</em>, so just download and run this exe which will launch <em>Android SDK Tool Setup</em> wizard to guide you throughout of the installation, so just follow the instructions carefully. Finally you will have <em>Android SDK Tools</em> installed on your machine.</p>\r\n\r\n<p>If you are installing SDK either on Mac OS or Linux, check the instructions provided along with the downloaded <em>android-sdk_rXX-macosx.zip</em> file for Mac OS and <em>android-sdk_rXX-linux.tgz</em> file for Linux. This tutorial will consider that you are going to setup your environment on Windows machine having Windows 7 operating system.</p>\r\n\r\n<p>So let&#39;s launch Android SDK Manager using the option <strong>All Programs &gt; Android SDK Tools &gt; SDK Manager</strong>, this<br />\r\nwill give you following window:</p>\r\n\r\n<p>Once you launched SDK manager, its time to install other required packages. By default it will list down total 7 packages to be installed, but I will suggest to de-select <em>Documentation for Android SDK and Samples for SDK</em> packages to reduce installation time. Next click <strong>Install 7 Packages </strong>button to proceed, which will display following dialogue box:</p>\r\n\r\n<p>If you agree to install all the packages, select <strong>Accept All</strong> radio button and proceed by clicking <strong>Install</strong> button. Now let SDK manager do its work and you go, pick up a cup of coffee and wait until all the packages are installed. It may take some time depending on your internet connection. Once all the packages are installed, you can close SDK manager using top-right cross button.</p>\r\n\r\n<h3>Step 3 - Setup Eclipse IDE</h3>\r\n\r\n<p>All the examples in this tutorial have been written using Eclipse IDE. So I would suggest you should have latest version of Eclipse installed on your machine.</p>\r\n\r\n<p>To install Eclipse IDE, download the latest Eclipse binaries from <a href="http://www.eclipse.org/downloads/" target="_blank">http://www.eclipse.org/downloads/</a>. Once you downloaded the installation, unpack the binary distribution into a convenient location. For example in C:eclipse on windows, or /usr/local/eclipse on Linux and finally set PATH variable appropriately.</p>\r\n\r\n<p>Eclipse can be started by executing the following commands on windows machine, or you can simply double click on eclipse.exe</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">%C:eclipseeclipse.exe</div>\r\n\r\n<p>Eclipse can be started by executing the following commands on Linux machine:</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">$/usr/local/eclipse/eclipse&nbsp;</div>\r\n\r\n<p>&nbsp;After a successful startup, if everything is fine then it should display following result:</p>\r\n\r\n<h3>Step 4 - Setup Android Development Tools (ADT) Plugin</h3>\r\n\r\n<p>This step will help you in setting Android Development Tool plugin for Eclipse. Let&#39;s start with launching Eclipse and then, choose <strong>Help &gt; Software Updates &gt; Install New Software</strong>. This will display the following dialogue box.</p>\r\n\r\n<p>Now use <strong>Add</strong> button to add <em>ADT Plugin</em> as name and <em>https://dl-ssl.google.com/android/eclipse/</em> as the location. Then click OK to add this location, as soon as you will click OK button to add this location, Eclipse starts searching for the plug-in available the given location and finally lists down the found plugins.</p>\r\n\r\n<p>Now select all the listed plug-ins using <strong>Select All</strong> button and click <strong>Next</strong> button which will guide you ahead to install Android Development Tools and other required plugins.</p>\r\n\r\n<h3>Step 5 - Create Android Virtual Device</h3>\r\n\r\n<p>To test your Android applications you will need a virtual Android device. So before we start writing our code, let us create an Android virtual device. Launch Android AVD Manager using Eclipse menu options <strong>Window &gt; AVD Manager &gt;</strong> which will launch Android AVD Manager. Use New button to create a new Android Virtual Device and enter the following information, before clicking <strong>Create AVD</strong> button.</p>\r\n\r\n<p>If your AVD is created successfully it means your environment is ready for Android application development. If you like, you can close this window using top-right cross button. Better you re-start your machine and once you are done with this last step, you are ready to proceed for your first Android example but before that we will see few more important concepts related to Android Application Development.</p>\r\n', '2014-06-10 22:18:20', '2014-06-20 21:46:23', 'imancha'),
(2, 1, 1, '<p>Reply Topic Content 1</p>\r\n', '2014-06-11 10:04:55', NULL, 'imancha'),
(3, 2, 2, '<p>Java programming language was originally developed by Sun Microsystems which was initiated by James Gosling and released in 1995 as core component of Sun Microsystems&rsquo; Java platform (Java 1.0 [J2SE]).</p>\r\n\r\n<p>As of December 2008, the latest release of the Java Standard Edition is 6 (J2SE). With the advancement of Java and its widespread popularity, multiple configurations were built to suite various types of platforms. Ex: J2EE for Enterprise Applications, J2ME for Mobile Applications.</p>\r\n\r\n<p>Sun Microsystems has renamed the new J2 versions as Java SE, Java EE and Java ME, respectively. Java is<br />\r\nguaranteed to be <strong>Write Once, Run Anywhere</strong>.</p>\r\n\r\n<p>Java is:</p>\r\n\r\n<ul>\r\n	<li><strong>Object Oriented</strong>: In Java, everything is an Object. Java can be easily extended since it is based on the Object model.</li>\r\n	<li><strong>Platform independent</strong>: Unlike many other programming languages including C and C++, when Java is compiled, it is not compiled into platform specific machine, rather into platform independent byte code. This byte code is distributed over the web and interpreted by virtual Machine (JVM) on whichever platform it is being run.</li>\r\n	<li><strong>Simple</strong>: Java is designed to be easy to learn. If you understand the basic concept of OOP,Java would be easy to master.</li>\r\n	<li><strong>Secure</strong>: With Java&#39;s secure feature, it enables to develop virus-free, tamper-free systems. Authentication techniques are based on public-key encryption.</li>\r\n	<li><strong>Architectural-neutral</strong>: Java compiler generates an architecture-neutral object file format, which makes the compiled code to be executable on many processors, with the presence of Java runtime system.</li>\r\n	<li><strong>Portable</strong>: Being architectural-neutral and having no implementation dependent aspects of the specification makes Java portable. Compiler inJava is written in ANSI C with a clean portability boundary which is a POSIX subset.</li>\r\n	<li><strong>Robust</strong>: Java makes an effort to eliminate error prone situations by emphasizing mainly on compile time error checking and runtime checking.</li>\r\n	<li><strong>Multithreaded</strong>: With Java&#39;s multithreaded feature, it is possible to write programs that can do many tasks simultaneously. This design feature allows developers to construct smoothly running interactive applications.</li>\r\n	<li><strong>Interpreted</strong>: Java byte code is translated on the fly to native machine instructions and is not stored anywhere. The development process is more rapid and analytical since the linking is an incremental and lightweight process.</li>\r\n	<li><strong>High Performance</strong>: With the use of Just-In-Time compilers, Java enables high performance.</li>\r\n	<li><strong>Distributed</strong>: Java is designed for the distributed environment of the internet.</li>\r\n	<li><strong>Dynamic</strong>: Java is considered to be more dynamic than C or C++ since it is designed to adapt to an evolving environment. Java programs can carry extensive amount of run-time information that can be used to verify and resolve accesses to objects on run-time.</li>\r\n</ul>\r\n\r\n<h3>History of Java:</h3>\r\n\r\n<p>James Gosling initiated the Java language project in June 1991 for use in one of his many set-top box projects. The language, initially called Oak after an oak tree that stood outside Gosling&#39;s office, also went by the name Green and ended up later being renamed as Java, from a list of random words.</p>\r\n\r\n<p>Sun released the first public implementation as Java 1.0 in 1995. It promised <strong>Write Once, Run Anywhere</strong> (WORA), providing no-cost run-times on popular platforms.</p>\r\n\r\n<p>On 13 November 2006, Sun released much of Java as free and open source software under the terms of the GNU General Public License (GPL).</p>\r\n\r\n<p>On 8 May 2007, Sun finished the process, making all of Java&#39;s core code free and open-source, aside from a small portion of code to which Sun did not hold the copyright.</p>\r\n\r\n<h3>Tools you will need:</h3>\r\n\r\n<p>For performing the examples discussed in this tutorial, you will need a Pentium 200-MHz computer with a minimum of 64 MB of RAM (128 MB of RAM recommended). You also will need the following softwares:</p>\r\n\r\n<ul>\r\n	<li>Linux 7.1 or Windows 95/98/2000/XP operating system.</li>\r\n	<li>Java JDK 5</li>\r\n	<li>Microsoft Notepad or any other text editor</li>\r\n</ul>\r\n\r\n<p>Java SE is freely available from the link Download Java. So you download a version based on your operating system.</p>\r\n\r\n<p>Follow the instructions to <a href="http://java.sun.com/javase/downloads/index_jdk5.jsp" target="_blank">download Java</a> and run the .exe to install Java on your machine. Once you installed Java on your machine, you would need to set environment variables to point to correct installation directories:</p>\r\n\r\n<h3>Setting up the path for windows 2000/XP:</h3>\r\n\r\n<p>Assuming you have installed Java in <em>c:Program Filesjavajdk</em> directory:</p>\r\n\r\n<ul>\r\n	<li>Right-click on &#39;My Computer&#39; and select &#39;Properties&#39;.</li>\r\n	<li>Click on the &#39;Environment variables&#39; button under the &#39;Advanced&#39; tab.</li>\r\n	<li>Now, alter the &#39;Path&#39; variable so that it also contains the path to the Java executable. Example, if the path is currently set to &#39;C:WINDOWSSYSTEM32&#39;, then change your path to read&#39;C:WINDOWSSYSTEM32;c:Program Filesjavajdkin&#39;.</li>\r\n</ul>\r\n\r\n<h3>Setting up the path for windows 95/98/ME:</h3>\r\n\r\n<p>Assuming you have installed Java in <em>c:Program Filesjavajdk</em> directory:</p>\r\n\r\n<ul>\r\n	<li>Edit the &#39;C:autoexec.bat&#39; file and add &#39;SET PATH=%PATH%;C:Program Filesjavajdkin&#39; the following line at the end:</li>\r\n</ul>\r\n\r\n<h3>Setting up the path for Linux, UNIX, Solaris, FreeBSD:</h3>\r\n\r\n<p>Environment variable PATH should be set to point to where the Java binaries have been installed. Refer to your shell documentation if you have trouble doing this.</p>\r\n\r\n<p>Example, if you use bash as your shell, then you would add the following line to the end of your &#39;.bashrc: export PATH=/path/to/java:$PATH&#39;</p>\r\n\r\n<h3>Popular Java Editors:</h3>\r\n\r\n<p>To write your Java programs, you will need a text editor. There are even more sophisticated IDEs available in the market. But for now, you can consider one of the following:</p>\r\n\r\n<ul>\r\n	<li><strong>Notepad</strong>: On Windows machine, you can use any simple text editor like Notepad (Recommended for this tutorial), TextPad.</li>\r\n	<li><strong>Netbeans</strong>: Is a Java IDE that is open-source and free which can be downloaded from <a href="http://www.netbeans.org/index.html" target="_blank">http://www.netbeans.org/index.html</a>.</li>\r\n	<li><strong>Eclipse</strong>: Is also a Java IDE developed by the eclipse open-source community and can be downloaded from <a href="http://www.eclipse.org/">http://www.eclipse.org/</a>.</li>\r\n</ul>\r\n', '2014-06-20 22:01:16', '2014-06-20 22:18:05', 'imancha'),
(4, 3, 3, '<p>Before you start doing programming using C++, you need the following two softwares available on yourcomputer.</p>\r\n\r\n<h3>Text Editor:</h3>\r\n\r\n<p>This will be used to type your program. Examples of few editors include Windows Notepad, OS Edit command, Brief, Epsilon, EMACS, and vim or vi.</p>\r\n\r\n<p>Name and version of text editor can vary on different operating systems. For example, Notepad will be used on Windows and vim or vi can be used on windows as well as Linux, or UNIX.</p>\r\n\r\n<p>The files you create with your editor are called source files, and for C++ they typically are named with the extension .cpp, .cp, or .c.</p>\r\n\r\n<p>Before starting your programming, make sure you have one text editor in place and you have enough experience to type your C++ program.</p>\r\n\r\n<h3>C++ Compiler:</h3>\r\n\r\n<p>This is actual C++ compiler, which will be used to compile your source code into final executable program.</p>\r\n\r\n<p>Most C++ compilers don&#39;t care what extension you give your source code, but if you don&#39;t specify otherwise, many will use .cpp by default.</p>\r\n\r\n<p>Most frequently used and free available compiler is GNU C/C++ compiler, otherwise you can have compilers either<br />\r\nfrom HP or Solaris if you have respective Operating Systems.</p>\r\n\r\n<h2>Installing GNU C/C++ Compiler:</h2>\r\n\r\n<h3>UNIX/Linux Installation:</h3>\r\n\r\n<p>If you are using <strong>Linux or UNIX</strong>, then check whether GCC is installed on your system by entering the following command from the command line:</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">$ g++-v</div>\r\n\r\n<p>If you have installed GCC, then it should print a message such as the following:</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">Using built-in specs.<br />\r\nTarget: i386-redhat-linux<br />\r\nConfiguredwith:../configure --prefix=/usr .......<br />\r\nThread model: posix<br />\r\ngcc version 4.1.220080704(RedHat4.1.2-46)</div>\r\n\r\n<p>If GCC is not installed, then you will have to install it yourself using the detailed instructions available at <a href="http://gcc.gnu.org/install/" target="_blank">http://gcc.gnu.org/install/</a>.</p>\r\n\r\n<h3>Mac OS X Installation:</h3>\r\n\r\n<p>If you use Mac OS X, the easiest way to obtain GCC is to download the Xcode development environment from Apple&#39;s web site and follow the simple installation instructions.</p>\r\n\r\n<p>Xcode is currently available at <a href="http://developer.apple.com/technologies/tools/" target="_blank">developer.apple.com/technologies/tools/</a>.</p>\r\n\r\n<h3>Windows Installation:</h3>\r\n\r\n<p>To install GCC at Windows, you need to install MinGW. To install MinGW, go to the MinGW homepage, <a href="http://www.mingw.org/">www.mingw.org</a>, and follow the link to the MinGW download page. Download the latest version of the MinGW installation program which should be named MinGW-&lt;version&gt;.exe.</p>\r\n\r\n<p>While installing MinWG, at a minimum, you must install gcc-core, gcc-g++, binutils, and the MinGW runtime, but you may wish to install more.</p>\r\n\r\n<p>Add the bin subdirectory of your MinGW installation to your <strong>PATH</strong> environment variable so that you can specify these tools on the command line by their simple names.</p>\r\n\r\n<p>When the installation is complete, you will be able to run gcc, g++, ar, ranlib, dlltool, and several other GNU tools from the Windows command line.&nbsp;</p>\r\n', '2014-06-20 22:23:13', '2014-06-20 22:29:17', 'imancha'),
(5, 4, 4, '<p>Before you start doing programming using C programming language, you need the following two softwares available on your computer, (a) Text Editor and (b) The C Compiler.</p>\r\n\r\n<h3>Text Editor</h3>\r\n\r\n<p>This will be used to type your program. Examples of few editors include Windows Notepad, OS Edit command, Brief, Epsilon, EMACS, and vim or vi.</p>\r\n\r\n<p>Name and version of text editor can vary on different operating systems. For example, Notepad will be used on Windows, and vim or vi can be used on windows as well as Linux or UNIX.</p>\r\n\r\n<p>The files you create with your editor are called source files and contain program source code. The source files for C programs are typically named with the extension &ldquo;.c&rdquo;.</p>\r\n\r\n<p>Before starting your programming, make sure you have one text editor in place and you have enough experience to write a computer program, save it in a file, compile it and finally execute it.</p>\r\n\r\n<h3>The C Compiler</h3>\r\n\r\n<p>The source code written in source file is the human readable source for your program. It needs to be &quot;compiled&quot;, to turn into machine language so that your CPU can actually execute the program as per instructions given.</p>\r\n\r\n<p>This C programming language compiler will be used to compile your source code into final executable program. I assume you have basic knowledge about a programming language compiler.</p>\r\n\r\n<p>Most frequently used and free available compiler is GNU C/C++ compiler, otherwise you can have compilers either from HP or Solaris if you have respective Operating Systems.</p>\r\n\r\n<p>Following section guides you on how to install GNU C/C++ compiler on various OS. I&#39;m mentioning C/C++ together because GNU gcc compiler works for both C and C++ programming languages.</p>\r\n\r\n<h3>Installation on UNIX/Linux</h3>\r\n\r\n<p>If you are using Linux or UNIX, then check whether GCC is installed on your system by entering the following command from the command line:</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">$ gcc -v</div>\r\n\r\n<p>If you have GNU compiler installed on your machine, then it should print a message something as follows:</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">Using built-in specs.<br />\r\nTarget: i386-redhat-linux<br />\r\nConfigured with: ../configure --prefix=/usr .......<br />\r\nThread model: posix<br />\r\ngcc version 4.1.2 20080704 (Red Hat 4.1.2-46)</div>\r\n\r\n<p>If GCC is not installed, then you will have to install it yourself using the detailed instructions available at <a href="http://gcc.gnu.org/install/" target="_blank">http://gcc.gnu.org/install/</a>.</p>\r\n\r\n<p>This tutorial has been written based on Linux and all the given examples have been compiled on Cent OS flavor of Linux system.</p>\r\n\r\n<h3>Installation on Mac OS</h3>\r\n\r\n<p>If you use Mac OS X, the easiest way to obtain GCC is to download the Xcode development environment from Apple&#39;s web site and follow the simple installation instructions. Once you have Xcode setup, you will be able to use GNU compiler for C/C++.</p>\r\n\r\n<p>Xcode is currently available at <a href="http://developer.apple.com/technologies/tools/" target="_blank">developer.apple.com/technologies/tools/</a>.</p>\r\n\r\n<h3>Installation on Windows</h3>\r\n\r\n<p>To install GCC at Windows you need to install MinGW. To install MinGW, go to the MinGW homepage, www.mingw.org, and follow the link to the MinGW download page. Download the latest version of the MinGW installation program, which should be named MinGW-&lt;version&gt;.exe.</p>\r\n\r\n<p>While installing MinWG, at a minimum, you must install gcc-core, gcc-g++, binutils, and the MinGW runtime, but you may wish to install more.</p>\r\n\r\n<p>Add the bin subdirectory of your MinGW installation to your PATH environment variable, so that you can specify these tools on the command line by their simple names.</p>\r\n\r\n<p>When the installation is complete, you will be able to run gcc, g++, ar, ranlib, dlltool, and several other GNU tools from the Windows command line.</p>\r\n', '2014-06-20 22:37:07', NULL, 'imancha'),
(6, 5, 5, '<p>In this chapter, we will discuss the tools required for creating C# programming. We have already mentioned that C# is part of .Net framework and is used for writing .Net applications. Therefore, before discussing the available tools for running a C# program, let us understand how C# relates to the .Net framework.</p>\r\n\r\n<h3>The .Net Framework</h3>\r\n\r\n<p>The .Net framework is a revolutionary platform that helps you to write the following types of applications:</p>\r\n\r\n<ul>\r\n	<li>Windows applications</li>\r\n	<li>Web applications</li>\r\n	<li>Web services</li>\r\n</ul>\r\n\r\n<p>The .Net framework applications are multi-platform applications. The framework has been designed in such a way that it can be used from any of the following languages: C#, C++, Visual Basic, Jscript, COBOL, etc. All these languages can access the framework as well as communicate with each other.</p>\r\n\r\n<p>The .Net framework consists of an enormous library of codes used by the client languages like C#. Following are some of the components of the .Net framework:</p>\r\n\r\n<ul>\r\n	<li>Common Language Runtime (CLR)</li>\r\n	<li>The .Net Framework Class Library</li>\r\n	<li>Common Language Specification</li>\r\n	<li>Common Type System</li>\r\n	<li>Metadata and Assemblies</li>\r\n	<li>Windows Forms</li>\r\n	<li>ASP.Net and ASP.Net AJAX</li>\r\n	<li>ADO.Net</li>\r\n	<li>Windows Workflow Foundation (WF)</li>\r\n	<li>Windows Presentation Foundation</li>\r\n	<li>Windows Communication Foundation (WCF)</li>\r\n	<li>LINQ</li>\r\n</ul>\r\n\r\n<p>For the jobs each of these components perform, please see <a href="http://www.tutorialspoint.com/asp.net/asp.net_introduction.htm" target="_blank">ASP.Net - Introduction</a>, and for details of each component, please consult Microsoft&#39;s documentation.</p>\r\n\r\n<h3>Integrated Development Environment (IDE) For C#</h3>\r\n\r\n<p>Microsoft provides the following development tools for C# programming:</p>\r\n\r\n<ul>\r\n	<li>Visual Studio 2010 (VS)</li>\r\n	<li>Visual C# 2010 Express (VCE)</li>\r\n	<li>Visual Web Developer</li>\r\n</ul>\r\n\r\n<p>The last two are freely available from Microsoft official website. Using these tools, you can write all kinds of C# programs from simple command-line applications to more complex applications. You can also write C# source code files using a basic text editor, like Notepad, and compile the code into assemblies using the command-line compiler, which is again a part of the .NET Framework.</p>\r\n\r\n<p>Visual C# Express and Visual Web Developer Express edition are trimmed down versions of Visual Studio and has the same look and feel. They retain most features of Visual Studio. In this tutorial, we have used Visual C# 2010 Express.</p>\r\n\r\n<p>You can download it from <a href="http://www.microsoft.com/visualstudio/eng/downloads" target="_blank">Microsoft Visual Studio</a>. It gets automatically installed in your machine. Please note that you need an active internet connection for installing the express edition.</p>\r\n\r\n<h3>Writing C# Programs on Linux or Mac OS</h3>\r\n\r\n<p>Although the.NET Framework runs on the Windows operating system, there are some alternative versions that work on other operating systems. <strong>Mono</strong> is an open-source version of the .NET Framework which includes a C# compiler and runs on several operating systems, including various flavors of Linux and Mac OS. Kindly check <a href="http://www.go-mono.com/mono-downloads/download.html" target="_blank">Go Mono</a>.</p>\r\n\r\n<p>The stated purpose of Mono is not only to be able to run Microsoft .NET applications cross-platform, but also to bring better development tools to Linux developers. Mono can be run on many operating systems including Android, BSD, iOS, Linux, OS X, Windows, Solaris and UNIX.&nbsp;</p>\r\n', '2014-06-20 22:45:42', NULL, 'imancha'),
(7, 6, 6, '<p>It is very easy to setup and start using Bootstrap. This chapter will explain how to download and setup Bootstrap. It will also discuss the Bootstrap file structure, and demonstrate its usage with an example.</p>\r\n\r\n<h2>Download Bootstrap</h2>\r\n\r\n<p>You can download the latest version of Bootstrap from <a href="http://getbootstrap.com/" target="_blank">http://getbootstrap.com/</a>. When you click on this link, you will get to see a screen as below:</p>\r\n\r\n<p>Here you can see two buttons:</p>\r\n\r\n<ul>\r\n	<li><em>Download Bootstrap</em>: Clicking this, you can download the precompiled and minified versions of Bootstrap CSS, JavaScript, and fonts. No documentation or original source code files are included.</li>\r\n	<li><em>Download Source</em>: Clicking this, you can get the latest Bootstrap LESS and JavaScript source code directly from GitHub.</li>\r\n</ul>\r\n\r\n<p>If you work with Bootstrap&#39;s uncompiled source code, you need to compile the LESS files to produce usable CSS files. For compiling LESS files into CSS, Bootstrap officially supports only <a href="http://twitter.github.io/recess/" target="_blank">Recess</a>, which is Twitter&#39;s CSS hinter based on <a href="http://lesscss.org/" target="_blank">less.js</a>.</p>\r\n\r\n<p>For better understanding and ease of use, we shall use precompiled version of Bootstrap throughout the tutorial. As the files are complied and minified you don&#39;t have to bother every time including separate files for individual functionality. At the time of writing this tutorial the latest version (Bootstrap 3) was downloaded.</p>\r\n\r\n<h2>File structure</h2>\r\n\r\n<h3>PRECOMPILED BOOTSTRAP</h3>\r\n\r\n<p>Once the compiled version Bootstrap is downloaded, extract the ZIP file, and you will see the following file/directory structure:</p>\r\n\r\n<p>As you can see there are compiled CSS and JS (bootstrap.*), as well as compiled and minified CSS and JS (bootstrap.min.*). Fonts from Glyphicons are included, as is the optional Bootstrap theme.</p>\r\n\r\n<h3>BOOTSTRAP SOURCE CODE</h3>\r\n\r\n<p>If you downloaded the Bootstrap source code then the file structure would be as follows:</p>\r\n\r\n<ul>\r\n	<li>The files under less/, js/, and fonts/ are the source code for Bootstrap CSS, JS, and icon fonts (respectively).</li>\r\n	<li>The dist/ folder includes everything listed in the precompiled download section above.</li>\r\n	<li>docs-assets/, examples/, and all *.html files are Bootstrap documentation.</li>\r\n</ul>\r\n\r\n<h2>HTML Template</h2>\r\n\r\n<p>A basic HTML template using Bootstrap would look like as this:&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">&lt;!DOCTYPE html&gt;<br />\r\n&lt;html&gt;<br />\r\n&nbsp; &lt;head&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;title&gt;Bootstrap 101 Template&lt;/title&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;!-- Bootstrap --&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;link href=&quot;css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot;&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;!-- WARNING: Respond.js doesn&#39;t work if you view the pagevia file:// --&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;!--[if lt IE 9]&gt;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src=&quot;https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js&quot;&gt;&lt;/script&gt;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src=&quot;https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js&quot;&gt;&lt;/script&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;![endif]--&gt;<br />\r\n&nbsp; &lt;/head&gt;<br />\r\n&nbsp; &lt;body&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;h1&gt;Hello, world!&lt;/h1&gt;<br />\r\n&nbsp; &nbsp; &lt;!-- jQuery (necessary for Bootstrap&#39;s JavaScript plugins) --&gt;<br />\r\n&nbsp; &nbsp; &lt;script src=&quot;https://code.jquery.com/jquery.js&quot;&gt;&lt;/script&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;!-- Include all compiled plugins (below), or include individual files as needed --&gt;<br />\r\n&nbsp;&nbsp;&nbsp; &lt;script src=&quot;js/bootstrap.min.js&quot;&gt;&lt;/script&gt;<br />\r\n&nbsp; &lt;/body&gt;<br />\r\n&lt;/html&gt;</div>\r\n\r\n<p>Here you can see the <strong>jquery.js</strong> and <strong>bootstrap.min.js</strong> and <strong>bootstrap.min.css</strong> files are included to make a normal HTM file to Bootstrapped Template.</p>\r\n\r\n<p>More details about each of the elements in this above piece of code will be discussed in the chapter <a href="http://www.tutorialspoint.com/bootstrap/bootstrap_css_overview.htm" target="_blank">Bootstrap CSS Overview</a>.</p>\r\n\r\n<p>This template structure is already included as part of the <strong>Try it</strong> tool. Hence in all the examples (in the following chapters) of this tutorial you shall only see the contents of the &lt;body&gt; element. Once you click on the <strong>Try it</strong> option available at the top right corner of example, you will see the entire code.&nbsp;</p>\r\n\r\n<h2>Example</h2>\r\n\r\n<p>Now let&#39;s try an example using the above template. Try following example using Try it option available at the top right corner of the below sample code box:</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">&lt;h1&gt;Hello, world!&lt;/h1&gt;</div>\r\n\r\n<p>&nbsp;</p>\r\n', '2014-06-20 23:11:18', '2014-06-20 23:53:39', 'imancha');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `title_topic` varchar(100) NOT NULL,
  `answers` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `date_topic` datetime NOT NULL,
  `reply_date_topic` datetime DEFAULT NULL,
  `creator_topic` varchar(30) NOT NULL,
  `last_post_by` varchar(30) NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `id_category` (`id_category`),
  KEY `creator_topic` (`creator_topic`),
  KEY `last_post_by` (`last_post_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id_topic`, `id_category`, `title_topic`, `answers`, `views`, `date_topic`, `reply_date_topic`, `creator_topic`, `last_post_by`) VALUES
(1, 1, 'Environment Setup Android Application Development', 1, 257, '2014-06-09 22:18:20', '2014-06-11 10:04:55', 'imancha', 'imancha'),
(2, 2, 'Java Environment Setup', 0, 8, '2014-06-20 22:01:16', '2014-06-20 22:01:16', 'imancha', 'imancha'),
(3, 3, 'C++ Environment Setup', 0, 2, '2014-06-20 22:23:13', '2014-06-20 22:23:13', 'imancha', 'imancha'),
(4, 4, 'C Environment Setup', 0, 0, '2014-06-20 22:37:07', '2014-06-20 22:37:07', 'imancha', 'imancha'),
(5, 5, 'C# Environment Setup', 0, 0, '2014-06-20 22:45:42', '2014-06-20 22:45:42', 'imancha', 'imancha'),
(6, 6, 'Bootstrap Environment Setup', 0, 2, '2014-06-20 23:11:18', '2014-06-20 23:11:18', 'imancha', 'imancha');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `active` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `city`, `email`, `date`, `active`) VALUES
(1, 'imancha', 'eb2f3b2278c1eb606a02a227fce6b51a1d1fec4e', 'Mohammad Abdul Iman Syah', 'Bandung', 'me@imanchaos.com', '2014-05-26', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`follower`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_message`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receiver_message`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`creator_post`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_4` FOREIGN KEY (`id_topic`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_3` FOREIGN KEY (`last_post_by`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`creator_topic`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
