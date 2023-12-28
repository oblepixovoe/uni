import QtQuick 2.15
import QtQuick.Window 2.15
import QtQuick.Layouts 1.13

Window {
    width: 480
    height: 640
    visible: true
    title: qsTr("Layouts")

    property int myMargin:10
    property int myMargin2:5

    ColumnLayout{
        anchors.fill:parent
        spacing: myMargin
        Comp{
            btext: "Header"
            color: "#FFFAA0"
            Layout.minimumHeight: parent.height/9
            Layout.minimumWidth: parent.width
        }
        Comp{
            btext: "Content"
            border.width: 1
            color: "#9370DB"
            border.color: "#9370DB"
            Layout.minimumHeight: (parent.height/9)*7-2*myMargin
            Layout.minimumWidth: parent.width-2*myMargin
            Layout.alignment: Qt.AlignLeft
            Layout.leftMargin: myMargin
            Layout.rightMargin: myMargin

        }
        RowLayout{
            spacing: myMargin2
            Layout.minimumHeight: parent.height/9
            Comp{
                btext: "1"
                color: "#FFFAA0"
                Layout.minimumWidth: parent.width/3
            }
            Comp{
                btext: "2"
                color: "#FFFAA0"
                Layout.minimumWidth: parent.width/3-2*myMargin2
            }
            Comp{
                btext: "3"
                color: "#FFFAA0"
                Layout.minimumWidth: parent.width/3
            }
        }
    }

}
