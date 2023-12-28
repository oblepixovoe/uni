import QtQuick 2.15
import QtQuick.Window 2.15


    Rectangle {
        property alias comText: rect1_text.text
        signal comClicked
        id: rect1
        height: footer.height
        width: footer.width/3-5
        color: "#d3d3d3"

        MouseArea {
            anchors.fill: parent
            onClicked: {
                header.headerText = "Header " + comText
                main_text.text = "Item " + comText + " content"
                comClicked()
            }
        }


        Text{
            id: rect1_text
            anchors.centerIn: parent
        }
    }

