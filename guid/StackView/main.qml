import QtQuick 2.15
import QtQuick.Window 2.15
import QtQuick.Controls 2.5
import QtQuick.Layouts 1.2

Window {
    width: 360
    height: 640
    visible: true
    title: qsTr("StackView_test")

    property int defMargin:10

    StackView{
        id:stack_view
        anchors.fill: parent
        initialItem: page1
    }
    Pg {
        id:page1
        backgroundColor: "red"
        buttonText_1: "To_Green"
        buttonText_2: "To_Yellow"
        onButtonClicked_1: {
            stack_view.push(page2)
        }
        onButtonClicked_2: {
            stack_view.push(page2)
            stack_view.push(page3)
        }
    }
    Pg {
        id:page2
        visible: false
        backgroundColor: "green"
        buttonText_1: "To_Red"
        buttonText_2: "To_Yellow"
        onButtonClicked_1: {
            stack_view.pop(page1)
        }
        onButtonClicked_2: {
            stack_view.push(page3)
        }
        onButtonClicked_back: {
            stack_view.pop(page1)

        }
    }
    Pg {
        id:page3
        visible: false
        backgroundColor: "yellow"
        buttonText_1: "To_Red"
        buttonText_2: "To_Green"
        onButtonClicked_1: {
            stack_view.pop(page1)
        }
        onButtonClicked_2: {
            stack_view.pop(page2)
        }
        onButtonClicked_back: {
            stack_view.pop(page2)
        }
    }
}
