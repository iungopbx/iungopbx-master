What is [IungoPBX](https://iungo.cloud/)?
--------------------------------------

[IungoPBX](https://iungo.cloud/) can be used as a single or domain based multi-tenant PBX, carrier grade switch, call center server, fax server, VoIP server, voicemail server, conference server, voice application server, multi-tenant appliance framework and more. [FreeSWITCH™](https://freeswitch.com) is a highly scalable, multi-threaded, multi-platform communication platform. 

It provides the functionality your business needs and brings carrier grade switching, and corporate-level phone system features to small, medium, and large businesses.

In addition to providing all of the usual PBX functionality, IungoPBX allows you to configure:

- Multi-Tenant
- Unlimited Extensions
- Voicemail-to-Email
- Device Provisioning
- Music on Hold
- Call Parking
- Automatic Call Distribution
- Interactive Voice Response
- Ring Groups
- Find Me / Follow Me
- Hot desking
- High Availability and Redundancy
- Dialplan Programming that allow nearly endless possibilities


Software Requirements
--------------------------------------

- IungoPBX will run on Debian, Ubuntu LTS, FreeBSD, CentOS, and more.

How to Install IungoPBX
----------------------------
* As root do the following:

Debian Install
```
wget -O - https://raw.githubusercontent.com/iungopbx/iungopbx-install.sh/master/debian/pre-install.sh | sh;
cd /usr/src/iungopbx-install.sh/debian && ./install.sh
```

Ubuntu Install
```
wget -O - https://raw.githubusercontent.com/iungopbx/iungopbx-install.sh/master/ubuntu/pre-install.sh | sh;
cd /usr/src/iungopbx-install.sh/ubuntu && ./install.sh
```

FreeBSD Install
```
pkg install --yes git
cd /usr/src && git clone https://github.com/iungopbx/iungopbx-install.sh.git
cd /usr/src/iungopbx-install.sh/freebsd && ./install.sh
```

CentOS Install
```
yum install wget
wget -O - https://raw.githubusercontent.com/iungopbx/iungopbx-install.sh/master/centos/pre-install.sh | sh
cd /usr/src/iungopbx-install.sh/centos && ./install.sh
```

This install script is designed to be an fast, simple, and in a modular way to install IungoPBX. Start with a minimal install with SSH enabled. Run the following commands under root. The script installs IungoPBX, FreeSWITCH release package and its dependencies, IPTables, Fail2ban, NGINX, PHP FPM and PostgreSQL.

Some installations require special considerations. Visit https://github.com/iungopbx/iungopbx-install.sh readme section for more details.

