import QtQuick 2.15
import QtQuick.Window 2.15
import QtQuick.Controls 2.5
import QtQuick.Layouts 1.3

Window {
    width: 360
    height: 640
    visible: true
    title: qsTr("Password Page")
    color:"#FFFAA0"
    Text {
        id: passwordField
        text: passwordField.text
        visible: false
    }
        Item {
            anchors.fill: parent
            ColumnLayout {
                anchors.centerIn: parent
                Text {
                    id: passwordTitle
                    text: "Enter your password:"
                    font.pixelSize: 16
                    Layout.alignment: Qt.AlignCenter
                }
                Rectangle {
                    id: passwordField1
                    width: parent.width
                    height: 50
                    Layout.alignment: Qt.AlignCenter
                    Row {
                        spacing: 6
                        anchors.centerIn: parent
                        Repeater {
                            model: 6
                            Label {
                                width: 20
                                height: 20
                                font.pixelSize: 36
                                text: "*"
                                Layout.alignment: Qt.AlignCenter
                                color: index < passwordField.text.length ? "black" : "#900C3F"
                            }
                        }
                    }
                }

                GridLayout {
                    id: keypad
                    rows: 4
                    columns: 3
                    width: parent.width
                    Button {
                        text: "1";font.pointSize: 11;onClicked: passwordField.text += "1"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "2";font.pointSize: 11;onClicked: passwordField.text += "2"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "3";font.pointSize: 11;onClicked: passwordField.text += "3"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "4";font.pointSize: 11;onClicked: passwordField.text += "4"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "5";font.pointSize: 11;onClicked: passwordField.text += "5"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "6";font.pointSize: 11;onClicked: passwordField.text += "6"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "7";font.pointSize: 11;onClicked: passwordField.text += "7"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "8";font.pointSize: 11;onClicked: passwordField.text += "8"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "9";font.pointSize: 11;onClicked: passwordField.text += "9"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: " ";font.pointSize: 11
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}

                    }

                    Button {
                        text: "0";font.pointSize: 11;onClicked: passwordField.text += "0"
                        background: Rectangle {color: "#FF5733";implicitWidth: 100}
                    }

                    Button {
                        text: "Clear";font.pointSize: 11;onClicked: passwordField.text = ""
                        background: Rectangle {color: "#DAF7A6";implicitWidth: 100}
                    }
                    Button {
                        text: "Log In";font.pointSize: 11
                        background: Rectangle {color: "#DAF7A6";implicitWidth: 100}
                    }

                }
            }
        }

}
