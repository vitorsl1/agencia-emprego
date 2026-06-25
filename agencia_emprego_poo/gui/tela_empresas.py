import tkinter as tk
from tkinter import messagebox, ttk

from models.empresa import Empresa


class TelaEmpresas(ttk.Frame):
    def __init__(self, master, agencia):
        super().__init__(master)
        self.agencia = agencia
        self._build()
        self.atualizar_lista()

    def _build(self):
        self.tree = ttk.Treeview(self, columns=("cnpj", "razao", "endereco"), show="headings")
        for col, txt in [("cnpj", "CNPJ"), ("razao", "Razão Social"), ("endereco", "Endereço")]:
            self.tree.heading(col, text=txt)
        self.tree.pack(fill="both", expand=True, padx=8, pady=8)

        actions = ttk.Frame(self)
        actions.pack(fill="x", padx=8, pady=(0, 8))
        ttk.Button(actions, text="Adicionar", command=self.adicionar).pack(side="left", padx=4)
        ttk.Button(actions, text="Editar", command=self.editar).pack(side="left", padx=4)
        ttk.Button(actions, text="Remover", command=self.remover).pack(side="left", padx=4)

    def atualizar_lista(self):
        for i in self.tree.get_children():
            self.tree.delete(i)
        for e in self.agencia.listar_empresas():
            self.tree.insert("", "end", values=(e.cnpj, e.razao_social, e.endereco))

    def _abrir_form(self, empresa=None):
        top = tk.Toplevel(self)
        top.title("Empresa")
        labels = ["CNPJ", "Razão Social", "Endereço"]
        vals = {
            "CNPJ": empresa.cnpj if empresa else "",
            "Razão Social": empresa.razao_social if empresa else "",
            "Endereço": empresa.endereco if empresa else "",
        }
        entries = {}
        for idx, label in enumerate(labels):
            ttk.Label(top, text=label).grid(row=idx, column=0, padx=6, pady=4, sticky="w")
            ent = ttk.Entry(top, width=40)
            ent.insert(0, vals[label])
            if empresa and label == "CNPJ":
                ent.configure(state="disabled")
            ent.grid(row=idx, column=1, padx=6, pady=4)
            entries[label] = ent

        def salvar():
            cnpj = entries["CNPJ"].get().strip()
            razao = entries["Razão Social"].get().strip()
            endereco = entries["Endereço"].get().strip()
            if not cnpj or not razao or not endereco:
                messagebox.showerror("Erro", "Todos os campos são obrigatórios.")
                return
            nova = Empresa(cnpj=cnpj, razao_social=razao, endereco=endereco)
            try:
                if empresa:
                    self.agencia.repo_empresa.atualizar(nova)
                else:
                    self.agencia.cadastrar_empresa(nova)
                self.atualizar_lista()
                top.destroy()
            except Exception as exc:
                messagebox.showerror("Erro", str(exc))

        ttk.Button(top, text="Salvar", command=salvar).grid(row=4, column=1, padx=6, pady=8, sticky="e")

    def adicionar(self):
        self._abrir_form()

    def editar(self):
        sel = self.tree.selection()
        if not sel:
            messagebox.showerror("Erro", "Selecione uma empresa.")
            return
        cnpj = self.tree.item(sel[0], "values")[0]
        empresa = self.agencia.repo_empresa.buscar_por_cnpj(cnpj)
        self._abrir_form(empresa)

    def remover(self):
        sel = self.tree.selection()
        if not sel:
            messagebox.showerror("Erro", "Selecione uma empresa.")
            return
        cnpj = self.tree.item(sel[0], "values")[0]
        try:
            self.agencia.repo_empresa.remover(cnpj)
            self.atualizar_lista()
        except Exception as exc:
            messagebox.showerror("Erro", str(exc))
