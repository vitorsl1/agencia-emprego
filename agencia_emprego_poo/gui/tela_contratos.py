from tkinter import messagebox, ttk

from models.contrato import Contrato

ESTIMATIVA_HORAS_MENSAIS = 160


class TelaContratos(ttk.Frame):
    def __init__(self, master, agencia):
        super().__init__(master)
        self.agencia = agencia
        self._build()
        self._carregar_comboboxes()

    def _build(self):
        form = ttk.Frame(self)
        form.pack(fill="x", padx=10, pady=10)

        ttk.Label(form, text="Profissional").grid(row=0, column=0, sticky="w", pady=4)
        self.cb_prof = ttk.Combobox(form, state="readonly", width=45)
        self.cb_prof.grid(row=0, column=1, sticky="w", pady=4)

        ttk.Label(form, text="Empresa").grid(row=1, column=0, sticky="w", pady=4)
        self.cb_emp = ttk.Combobox(form, state="readonly", width=45)
        self.cb_emp.grid(row=1, column=1, sticky="w", pady=4)

        ttk.Label(form, text="Data início (AAAA-MM-DD)").grid(row=2, column=0, sticky="w", pady=4)
        self.ent_inicio = ttk.Entry(form, width=20)
        self.ent_inicio.grid(row=2, column=1, sticky="w", pady=4)

        ttk.Label(form, text="Data término (AAAA-MM-DD)").grid(row=3, column=0, sticky="w", pady=4)
        self.ent_fim = ttk.Entry(form, width=20)
        self.ent_fim.grid(row=3, column=1, sticky="w", pady=4)

        ttk.Label(form, text="Valor por hora").grid(row=4, column=0, sticky="w", pady=4)
        self.ent_valor = ttk.Entry(form, width=20)
        self.ent_valor.grid(row=4, column=1, sticky="w", pady=4)

        ttk.Button(form, text="Registrar Contrato", command=self.registrar).grid(row=5, column=1, sticky="e", pady=8)

    def _carregar_comboboxes(self):
        self.profissionais = self.agencia.listar_profissionais()
        self.empresas = self.agencia.listar_empresas()
        self.cb_prof["values"] = [f"{p.cpf} - {p.nome}" for p in self.profissionais]
        self.cb_emp["values"] = [f"{e.cnpj} - {e.razao_social}" for e in self.empresas]

    def registrar(self):
        try:
            idx_prof = self.cb_prof.current()
            idx_emp = self.cb_emp.current()
            if idx_prof < 0 or idx_emp < 0:
                messagebox.showerror("Erro", "Selecione profissional e empresa.")
                return
            valor_hora = float(self.ent_valor.get().strip())
            if valor_hora <= 0:
                raise ValueError("Valor por hora deve ser maior que zero.")

            contrato = Contrato(
                profissional=self.profissionais[idx_prof],
                empresa=self.empresas[idx_emp],
                data_inicio=self.ent_inicio.get().strip(),
                data_termino=self.ent_fim.get().strip(),
                valor_hora=valor_hora,
            )
            estimado = contrato.calcular_valor_total(ESTIMATIVA_HORAS_MENSAIS)
            if not messagebox.askyesno(
                "Confirmação",
                f"Valor estimado ({ESTIMATIVA_HORAS_MENSAIS}h): R$ {estimado:.2f}. Confirmar?",
            ):
                return
            numero = self.agencia.registrar_contrato(contrato)
            messagebox.showinfo("Sucesso", f"Contrato #{numero} registrado.")
        except ValueError as exc:
            messagebox.showerror("Erro", str(exc))
        except Exception as exc:
            messagebox.showerror("Erro", f"Falha ao registrar contrato: {exc}")
