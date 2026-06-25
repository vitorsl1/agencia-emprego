from tkinter import ttk


class TelaHistorico(ttk.Frame):
    def __init__(self, master, agencia):
        super().__init__(master)
        self.agencia = agencia
        self._build()
        self.atualizar_lista()

    def _build(self):
        filtros = ttk.Frame(self)
        filtros.pack(fill="x", padx=8, pady=8)

        ttk.Label(filtros, text="Filtrar profissional").pack(side="left", padx=(0, 4))
        self.cb_prof = ttk.Combobox(filtros, state="readonly", width=30)
        self.cb_prof.pack(side="left", padx=(0, 8))

        ttk.Label(filtros, text="Filtrar empresa").pack(side="left", padx=(0, 4))
        self.cb_emp = ttk.Combobox(filtros, state="readonly", width=30)
        self.cb_emp.pack(side="left", padx=(0, 8))

        ttk.Button(filtros, text="Aplicar", command=self.atualizar_lista).pack(side="left", padx=4)
        ttk.Button(filtros, text="Limpar", command=self.limpar).pack(side="left", padx=4)

        self.tree = ttk.Treeview(
            self,
            columns=("numero", "profissional", "empresa", "inicio", "fim", "valor"),
            show="headings",
        )
        for col, txt in [
            ("numero", "Número"),
            ("profissional", "Profissional"),
            ("empresa", "Empresa"),
            ("inicio", "Início"),
            ("fim", "Término"),
            ("valor", "Valor/hora"),
        ]:
            self.tree.heading(col, text=txt)
        self.tree.pack(fill="both", expand=True, padx=8, pady=8)

    def limpar(self):
        self.cb_prof.set("")
        self.cb_emp.set("")
        self.atualizar_lista()

    def atualizar_lista(self):
        contratos = self.agencia.listar_contratos()
        prof_values = sorted({c.profissional.nome for c in contratos})
        emp_values = sorted({c.empresa.razao_social for c in contratos})
        self.cb_prof["values"] = [""] + prof_values
        self.cb_emp["values"] = [""] + emp_values

        filtro_prof = self.cb_prof.get().strip()
        filtro_emp = self.cb_emp.get().strip()

        for i in self.tree.get_children():
            self.tree.delete(i)

        for c in contratos:
            if filtro_prof and c.profissional.nome != filtro_prof:
                continue
            if filtro_emp and c.empresa.razao_social != filtro_emp:
                continue
            self.tree.insert(
                "",
                "end",
                values=(c.numero, c.profissional.nome, c.empresa.razao_social, c.data_inicio, c.data_termino, f"R$ {c.valor_hora:.2f}"),
            )
