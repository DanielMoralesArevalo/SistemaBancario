CREATE PROCEDURE [dbo].[PA_CREAR_USUARIO] 
	-- Add the parameters for the stored procedure here
	@NOMBRE varchar(100) = NULL,
	@APELLIDO varchar(100) = NULL,
	@ID_ROL int = 1,
	@DOCUMENTO int = NULL,
	@CLAVE varchar(500) = NULL,

	@ID_SUCURSAL int = NULL,
	@ID_TIP_CUENTA INT = NULL

AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	-- Insert statements for procedure here
	IF EXISTS (SELECT * FROM PERSONAS WHERE [DOCUMENTO] = @DOCUMENTO)
	BEGIN
		RETURN RETURN CAST(1 AS bit);
	END
	ELSE
	BEGIN
		INSERT INTO [dbo].[PERSONAS]
			([NOMBRES]
			,[APELLIDOS]
			,[DOCUMENTO]
			,ID_ROL
			,CLAVE)
		VALUES
			(@NOMBRE
			,@APELLIDO
			,@DOCUMENTO
			,1
			,@CLAVE)

		DECLARE @ID_PERSONA INT = ( SELECT SCOPE_IDENTITY())

		INSERT INTO [dbo].CUENTAS
			   (NUM_CUENTA
			   ,ID_PERSONA
			   ,ID_SUCURSAL
			   ,ID_TIP_CUENTA
			   ,SALDO)
		 VALUES
			   (1000000+@ID_PERSONA
			   ,@ID_PERSONA
			   ,@ID_SUCURSAL
			   ,@ID_TIP_CUENTA
			   ,0)
		RETURN CAST(0 AS bit);
	END

END

/////////////////////////////////////////////////////////////////////////////////////

CREATE PROCEDURE [dbo].[PA_LOGIN] 
	-- Add the parameters for the stored procedure here
	@DOCUMENT VARCHAR(50) = NULL, 
	@PASSWORD VARCHAR(50) = NULL 
	
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	SELECT NOMBRES,APELLIDOS,DOCUMENTO,R.ROL 
	FROM PERSONAS P 
	INNER JOIN ROLES R ON R.ID_ROL = P.ID_ROL
	WHERE DOCUMENTO = @DOCUMENT AND CLAVE = @PASSWORD
END