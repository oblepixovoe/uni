import QtQuick 2.15
import QtQuick.Window 2.15
import QtQuick.Layouts 1.12
Window {
    width: 540
    height: 960
    color: "#f5f5f5"
    title: qsTr("UserInteractions")
    visible: true
    ColumnLayout {
        id: grid
        anchors.fill: parent

        Header{
            id: header

            headerText: "Header"
            Layout.fillWidth: true
        }

        Rectangle {

            Layout.fillWidth: true
            Layout.fillHeight: true
            id:rect_mid

            GridLayout{
                anchors.fill: parent
                rows: 1
                columns: 1
                Rectangle {
                    Layout.topMargin: 3
                    Layout.bottomMargin: 3
                    Layout.leftMargin: 5
                    Layout.rightMargin: 5
                    color: "#f5f5f5"
                    border.color: "#dadada"
                    Layout.fillWidth: true
                    Layout.fillHeight: true
                    border.width: 1
                    Text{
                        id:main_text
                        text: "Content"
                        anchors.centerIn: parent
                    }
                }
            }
        }

        Footer{
            Layout.fillWidth: true
        }

    }
}
