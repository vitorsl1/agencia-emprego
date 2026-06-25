import tkinter as tk
from tkinter import messagebox, ttk

from models.profissional import Profissional


class TelaProfissionais(ttk.Frame):
    def __init__(self, master, agencia):
        super().__init__(master)
        self.agencia = agencia
        self._build()
        self.atualizar_lista()

    def _build(self):
        self.tree = ttk.Treeview(self, columns=("cpf", "nome", "profissao", "nasc", "endereco"), show="headings")
        for col, txt in [
            ("cpf", "CPF"),
            ("nome", "Nome"),
            ("profissao", "Profissão"),
            ("nasc", "Data Nasc."),
            ("endereco", "Endereço"),
        ]:
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
        for p in self.agencia.listar_profissionais():
            self.tree.insert("", "end", values=(p.cpf, p.nome, p.profissao, p.data_nascimento, p.endereco))

    def _abrir_form(self, profissional=None):
        top = tk.Toplevel(self)
        top.title("Profissional")
        labels = ["CPF", "Nome", "Profissão", "Data Nascimento", "Endereço"]
        vals = {
            "CPF": profissional.cpf if profissional else "",
            "Nome": profissional.nome if profissional else "",
            "Profissão": profissional.profissao if profissional else "",
            "Data Nascimento": profissional.data_nascimento if profissional else "",
            "Endereço": profissional.endereco if profissional else "",
        }
        entries = {}
        for idx, label in enumerate(labels):
            ttk.Label(top, text=label).grid(row=idx, column=0, padx=6, pady=4, sticky="w")
            ent = ttk.Entry(top, width=40)
            ent.insert(0, vals[label])
            if profissional and label == "CPF":
                ent.configure(state="disabled")
            ent.grid(row=idx, column=1, padx=6, pady=4)
            entries[label] = ent

        def salvar():
            cpf = entries["CPF"].get().strip()
            nome = entries["Nome"].get().strip()
            profissao = entries["Profissão"].get().strip()
            data_nascimento = entries["Data Nascimento"].get().strip()
            endereco = entries["Endereço"].get().strip()
            if not cpf or not nome or not profissao or not data_nascimento or not endereco:
                messagebox.showerror("Erro", "Todos os campos são obrigatórios.")
                return

            novo = Profissional(
                cpf=cpf,
                nome=nome,
                profissao=profissao,
                data_nascimento=data_nascimento,
                endereco=endereco,
            )
            try:
                if profissional:
                    self.agencia.repo_profissional.atualizar(novo)
                else:
                    self.agencia.cadastrar_profissional(novo)
                self.atualizar_lista()
                top.destroy()
            except Exception as exc:
                messagebox.showerror("Erro", str(exc))

        ttk.Button(top, text="Salvar", command=salvar).grid(row=6, column=1, padx=6, pady=8, sticky="e")

    def adicionar(self):
        self._abrir_form()

    def editar(self):
        sel = self.tree.selection()
        if not sel:
            messagebox.showerror("Erro", "Selecione um profissional.")
            return
        cpf = self.tree.item(sel[0], "values")[0]
        profissional = self.agencia.repo_profissional.buscar_por_cpf(cpf)
        self._abrir_form(profissional)

    def remover(self):
        sel = self.tree.selection()
        if not sel:
            messagebox.showerror("Erro", "Selecione um profissional.")
            return
        cpf = self.tree.item(sel[0], "values")[0]
        try:
            self.agencia.repo_profissional.remover(cpf)
            self.atualizar_lista()
        except Exception as exc:
            messagebox.showerror("Erro", str(exc))
