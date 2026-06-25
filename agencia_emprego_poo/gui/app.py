import tkinter as tk
from tkinter import messagebox, ttk

from gui.tela_contratos import TelaContratos
from gui.tela_empresas import TelaEmpresas
from gui.tela_historico import TelaHistorico
from gui.tela_profissionais import TelaProfissionais
from models.agencia import AgenciaEmprego


class AppGUI:
    def __init__(self, db_path: str = "agencia.db"):
        try:
            self.agencia = AgenciaEmprego(db_path)
        except Exception as exc:
            root = tk.Tk()
            root.withdraw()
            messagebox.showerror("Erro de conexão", str(exc))
            raise

        self.root = tk.Tk()
        self.root.title("Agência de Emprego Temporário")
        self.root.geometry("1100x650")

        notebook = ttk.Notebook(self.root)
        notebook.pack(fill="both", expand=True)

        self.tela_profissionais = TelaProfissionais(notebook, self.agencia)
        self.tela_empresas = TelaEmpresas(notebook, self.agencia)
        self.tela_contratos = TelaContratos(notebook, self.agencia)
        self.tela_historico = TelaHistorico(notebook, self.agencia)

        notebook.add(self.tela_profissionais, text="Profissionais")
        notebook.add(self.tela_empresas, text="Empresas")
        notebook.add(self.tela_contratos, text="Contratos")
        notebook.add(self.tela_historico, text="Histórico")

        def ao_mudar_aba(_):
            self.tela_profissionais.atualizar_lista()
            self.tela_empresas.atualizar_lista()
            self.tela_contratos._carregar_comboboxes()
            self.tela_historico.atualizar_lista()

        notebook.bind("<<NotebookTabChanged>>", ao_mudar_aba)

    def run(self):
        self.root.mainloop()
