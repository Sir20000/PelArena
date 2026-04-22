; --- Ouvrir automatiquement le clavier tactile de Windows 11 ---

#Persistent

; Quand tu appuies dans une zone de texte (CTRL+LButton simule clic dans input), lance le clavier tactile
~LButton::
    ; Vérifie si la fenêtre active est un champ texte
    ControlGetFocus, ctrl, A
    if (InStr(ctrl, "Edit") || InStr(ctrl, "RichEdit") || InStr(ctrl, "Chrome_RenderWidgetHostHWND"))
    {
        Run, tabtip.exe
    }
return

; Raccourci manuel pour fermer le clavier tactile avec CTRL+ESC
^Esc::
    Run, taskkill /IM TabTip.exe /F
return
