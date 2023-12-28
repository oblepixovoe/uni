import QtQuick 2.15
import QtQuick.Window 2.15
import QtQuick.Controls 2.5


Window {
    id: win
    minimumWidth: 90
    minimumHeight: 160
    width: 360
    height: 640
    visible: true
    title: qsTr("ListView")
    property int defMargin: 8
    Page{
        id:page
        anchors.fill:parent
        Rectangle{
            id:rect
            anchors.fill:parent
            gradient:Gradient{
                GradientStop{position:0;color:"#FFFAA0"}
                GradientStop{position:1;color:"white"}
            }
        }
        ListModel{
            id:my_model
            ListElement{ message:"Hello"; time:"12:00"}
            ListElement{ message:"Bye"; time:"12:01"}
            ListElement{ message:"😭"; time:"12:02"}
        }
        Component{
            id:my_delegate
            MyDelegate{
                message:model.message
                time:model.time
                width:win.width/1.2
                height:40
                anchors.horizontalCenter: parent.horizontalCenter
            }
        }
        ListView{
            id:my_list
            anchors.fill:parent
            spacing:10
            anchors.topMargin:20
            model:my_model
            delegate:my_delegate
        }

        footer: PageFooter {
            onNewMessage: {
                var newMsg = {};
                newMsg.message = msg;
                newMsg.time = Qt.formatTime(new Date(), "hh:mm");
                my_model.append(newMsg);
            }
        }
    }
}
