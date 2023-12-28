import QtQuick 2.15
import QtQuick.Layouts 1.13

Rectangle {
    property alias btext: txt.text

    Layout.fillHeight: true
    Layout.fillWidth: true
    width: 300
    height: 200
    Text{
        id: txt
        anchors.centerIn: parent
    }
}

