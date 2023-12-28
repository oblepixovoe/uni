import QtQuick 2.15

Item {
    id:deleg
    property string message: "?"
    property string time: "?"
    Rectangle{
        id:rect
        border.color:"darkgrey"
        radius:10
        anchors.fill:parent
        gradient:Gradient{
            GradientStop{position:0;color:"lightgray"}
            GradientStop{position:0.7;color:"lightgray"}
            GradientStop{position:1;color:"white"}
        }
    }

    Row{
        id:row
        anchors.left:parent.left
        anchors.right: parent.right
        height:parent.height
        anchors.margins: 16
        spacing:6
        Text{
            text:message;
            anchors.verticalCenter:row.verticalCenter
        }
        Text{
            text:time;
            anchors.bottom:parent.bottom
            anchors.right:parent.right
        }
    }
}
